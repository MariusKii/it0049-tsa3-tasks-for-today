<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Database\Seeders\TaskSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Frozen application time makes these tests independent of the date they run.
        $this->travelTo(Carbon::parse('2026-11-12 12:00:00', 'Asia/Manila'));
    }

    public function test_welcome_page_loads_and_shows_today_task_and_counts(): void
    {
        Task::factory()->create(['title' => 'Today pending task', 'task_date' => today()]);
        Task::factory()->create(['title' => 'Today completed task', 'status' => 'completed', 'task_date' => today()]);
        $this->get('/')->assertOk()->assertSee('Today pending task')->assertSee('Today completed task')
            ->assertViewHas('tasks', fn ($tasks) => $tasks->count() === 2)
            ->assertViewHas('pendingCount', 1)->assertViewHas('completedCount', 1)
            ->assertViewHas('completionRate', 50);
    }

    public function test_welcome_excludes_both_past_and_future_tasks(): void
    {
        Task::factory()->create(['title' => 'Yesterday hidden task', 'task_date' => today()->subDay()]);
        Task::factory()->create(['title' => 'Tomorrow hidden task', 'task_date' => today()->addDay()]);
        $this->get('/')->assertOk()->assertDontSee('Yesterday hidden task')->assertDontSee('Tomorrow hidden task')
            ->assertViewHas('tasks', fn ($tasks) => $tasks->isEmpty());
    }

    public function test_welcome_handles_no_tasks_today(): void
    {
        $this->get('/')->assertOk()->assertSee('A little breathing room')->assertViewHas('completionRate', 0);
    }

    public function test_today_uses_manila_calendar_date_when_utc_is_still_yesterday(): void
    {
        $this->travelTo(Carbon::parse('2026-11-11 16:01:00', 'UTC'));
        Task::factory()->create(['title' => 'Manila current date', 'task_date' => '2026-11-12']);
        Task::factory()->create(['title' => 'UTC previous date', 'task_date' => '2026-11-11']);
        $this->get('/')->assertOk()->assertSee('Manila current date')->assertDontSee('UTC previous date');
    }

    public function test_task_list_includes_every_date_and_orders_by_date(): void
    {
        Task::factory()->create(['title' => 'Future task', 'task_date' => today()->addDay()]);
        Task::factory()->create(['title' => 'Past task', 'task_date' => today()->subDay()]);
        Task::factory()->create(['title' => 'Current task', 'task_date' => today()]);
        $this->get('/tasks')->assertOk()->assertSeeInOrder(['Past task', 'Current task', 'Future task'])
            ->assertViewHas('tasks', fn ($tasks) => $tasks->count() === 3);
    }

    public function test_task_list_handles_empty_database(): void
    {
        $this->get('/tasks')->assertOk()->assertSee('Your schedule starts here');
    }

    public function test_profile_renders_database_values_instead_of_hardcoded_identity(): void
    {
        User::factory()->create(['full_name' => 'Database Test Person', 'username' => 'test_profile', 'email' => 'test@example.invalid']);
        $this->get('/profile')->assertOk()->assertSee('Database Test Person')->assertSee('test_profile')->assertSee('test@example.invalid');
    }

    public function test_missing_profile_is_handled_gracefully(): void
    {
        $this->get('/profile')->assertOk()->assertSee('No profile available yet');
    }

    public function test_about_identifies_the_developer_and_technologies(): void
    {
        $this->get('/about')->assertOk()->assertSee('Marius De Asis')->assertSee('IT0049')
            ->assertSee('Technical Summative Assessment 3')->assertSee('Eloquent ORM');
    }

    public function test_all_four_pages_share_navigation_and_layout(): void
    {
        foreach (['/', '/tasks', '/profile', '/about'] as $url) {
            $this->get($url)->assertOk()->assertSee('Main navigation')->assertSee('Skip to content')
                ->assertSee('css/app.css')->assertSee('aria-current="page"', false);
        }
    }

    public function test_seed_data_is_sufficient_and_safely_repeatable(): void
    {
        $this->seed();
        $this->seed();
        $this->assertDatabaseCount('tasks', 8);
        $this->assertDatabaseCount('users', 1);
        $this->assertSame(3, Task::get()->pluck('task_date')->map->toDateString()->unique()->count());
        $this->assertSame(4, Task::whereDate('task_date', today())->count());
        $this->assertSame(2, Task::whereDate('task_date', today()->subDay())->count());
        $this->assertSame(2, Task::whereDate('task_date', today()->addDay())->count());
        $this->assertDatabaseHas('users', ['full_name' => 'Marius De Asis', 'username' => 'CHANGE_ME']);
    }

    public function test_reseeding_on_a_later_day_moves_demo_dates_without_duplicates(): void
    {
        $this->seed(TaskSeeder::class);
        $this->travel(2)->days();
        $this->seed(TaskSeeder::class);
        $this->assertDatabaseCount('tasks', 8);
        $this->assertSame(4, Task::whereDate('task_date', today())->count());
    }

    public function test_seeding_preserves_existing_profiles_and_unrelated_tasks(): void
    {
        $users = User::factory()->count(2)->create();
        $task = Task::factory()->create(['title' => 'Preserve this task']);
        $this->seed();
        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('tasks', 9);
        foreach ($users as $user) {
            $this->assertDatabaseHas('users', ['id' => $user->id, 'username' => $user->username]);
        }
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Preserve this task']);
    }

    public function test_profile_seeder_does_not_overwrite_edited_placeholders(): void
    {
        $this->seed(UserSeeder::class);
        User::first()->update(['username' => 'my_username', 'email' => 'chosen@example.invalid']);
        $this->seed(UserSeeder::class);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['username' => 'my_username', 'email' => 'chosen@example.invalid']);
    }

    public function test_task_status_defaults_to_pending_in_the_database(): void
    {
        $task = Task::create(['title' => 'Default status task', 'task_date' => today()]);
        $this->assertSame('pending', $task->fresh()->status);
        $this->assertInstanceOf(Carbon::class, $task->fresh()->task_date);
    }

    public function test_username_has_a_database_unique_constraint(): void
    {
        User::factory()->create(['username' => 'duplicate_name']);
        $this->expectException(QueryException::class);
        User::factory()->create(['username' => 'duplicate_name']);
    }

    public function test_titles_and_profile_values_are_html_escaped(): void
    {
        Task::factory()->create(['title' => '<script>alert(1)</script>', 'task_date' => today()]);
        User::factory()->create(['full_name' => '<script>alert(2)</script>']);
        $this->get('/')->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
        $this->get('/profile')->assertSee('&lt;script&gt;alert(2)&lt;/script&gt;', false)->assertDontSee('<script>alert(2)</script>', false);
    }
}
