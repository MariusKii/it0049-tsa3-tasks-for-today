<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $today = today(config('app.timezone'));
        $samples = [
            ['Review PHP fundamentals', -1, 'completed'],
            ['Complete database migration', -1, 'completed'],
            ['Review Laravel documentation', 0, 'completed'],
            ['Study Eloquent relationships', 0, 'pending'],
            ['Submit laboratory requirements', 0, 'pending'],
            ['Test application routes', 0, 'completed'],
            ['Prepare project documentation', 1, 'pending'],
            ['Finalize GitHub repository', 1, 'pending'],
        ];
        foreach ($samples as [$title, $offset, $status]) {
            // Stable titles identify these demo records, even when reseeded on another day.
            Task::updateOrCreate(['title' => $title], [
                'status' => $status,
                'task_date' => $today->copy()->addDays($offset)->toDateString(),
            ]);
        }
    }
}
