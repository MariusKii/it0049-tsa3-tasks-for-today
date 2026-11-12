# IT0049 TSA3 implementation report

## 1. Implementation summary

Built a complete read-only Tasks for Today Management System for Marius De Asis using Laravel 13.42.0, PHP, Blade, Eloquent, and SQLite. All four required pages share a responsive dashboard layout with navigation, accessible status labels, empty states, and local CSS/SVG assets. No frontend build, authentication, or task editing workflow is required.

The empty workspace was initialized as a new application. No unrelated project was reused. The original TSA1 source was unavailable, so the supplied assessment's explicitly listed fields were used. Application dates follow Asia/Manila. Username and email use editable placeholders because actual values were not provided.

## 2. Project structure

- `app/Models/Task.php` and `User.php`: Eloquent models and mass-assignable fields; date cast on Task.
- `app/Http/Controllers/`: WelcomeController, TaskController, ProfileController, AboutController.
- `database/migrations/`: users and tasks schemas.
- `database/seeders/`: DatabaseSeeder, TaskSeeder, UserSeeder.
- `database/factories/`: task and user fixtures for testing.
- `resources/views/layouts/app.blade.php`: shared layout.
- `resources/views/components/`: icons and reused task table.
- `resources/views/`: welcome, tasks/index, profile, and about pages.
- `public/css/app.css`: responsive dashboard styles.
- `routes/web.php`: four named controller routes.
- `tests/Feature/TaskManagementTest.php`: 17 feature tests.
- `README.md`: installation, schema, usage, tests, GitHub submission, and hosting instructions.

## 3. Database schema

| Table | Fields |
| --- | --- |
| tasks | id primary key; title string; status string default pending; task_date date; created_at and updated_at timestamps |
| users | id primary key; username unique string; full_name string; email string; created_at and updated_at timestamps |

The database also contains Laravel's migrations bookkeeping table. There are no extra authentication, jobs, sessions, or cache tables. Migrations and seeders are included, so a database export is unnecessary for submission.

## 4. Seeded records

Verified on November 12, 2026, in Asia/Manila:

| Scheduled date | Tasks | Statuses |
| --- | --- | --- |
| November 11, 2026 | Review PHP fundamentals; Complete database migration | Both completed |
| November 12, 2026 | Review Laravel documentation; Study Eloquent relationships; Submit laboratory requirements; Test application routes | Completed; pending; pending; completed |
| November 13, 2026 | Prepare project documentation; Finalize GitHub repository | Both pending |

Total: **8 tasks across 3 dates**, with **4 today**, **2 pending today**, and **2 completed today**. Exactly **1 user profile**: Marius De Asis, username `CHANGE_ME`, email `change-me@example.invalid`.

These dates are a verification snapshot. The seeder calculates yesterday/today/tomorrow dynamically and can refresh the demo on another day. Repeat seeding updates the same sample titles without duplicates, preserves unrelated tasks, and preserves existing profiles. More than one existing profile produces a warning rather than deletion. The README explains these semantics.

## 5. Application routes

| URL path | Purpose | Data retrieval |
| --- | --- | --- |
| `/` | Today's Tasks | Eloquent whereDate against the application calendar date |
| `/tasks` | All Tasks | All Eloquent tasks ordered by task_date, then id |
| `/profile` | My Profile | First User record by id; friendly fallback if absent |
| `/about` | About the Application | Static developer and course information |

The current local preview is http://127.0.0.1:8053. It is not a public hosted URL. A standard `php artisan serve` command uses port 8000.

## 6. Testing results

**17 feature tests passed with 76 assertions**, both in the working copy and after a clean source-archive extraction, dependency installation, environment setup, migration, and seeding. Tests use isolated in-memory SQLite and a frozen date. Verified:

- Welcome route loads, includes today's tasks, and excludes yesterday/tomorrow.
- Counts and progress reflect today's records only.
- Manila's date is correct when UTC is still on the previous day.
- Full task list includes all dates in ascending order.
- Empty task lists and missing profile render gracefully.
- Profile values come from database records, including a different test identity.
- About content and shared layout are present.
- Seed count/date distribution, same-day reseeding, next-day reseeding, edited profile preservation, and unrelated record preservation.
- Database default pending status, date casting, unique username constraint, and HTML escaping.

Additional successful checks: migrations and seeding, application environment boot, four controller routes, Blade compilation, Laravel Pint formatting, Composer manifest validation, dependency platform requirements, and direct Eloquent data inspection. All four pages were loaded and visually checked in the browser. Dashboard layout was checked at 1280px desktop, 660px browser, and 390px mobile iframe viewport widths. Mobile tables scroll horizontally.

MySQL, production hosting, and exhaustive browser/accessibility audits were not executed. Production deployment verification remains pending. The GitHub repository is public under MariusKii.

## 7. Commands

For the prepared local project:

```sh
cd tasks-for-today
php artisan serve --port=8053
```

If the existing preview server is still running, open it directly instead of starting another process on the same port.

For a fresh extraction or clone:

```sh
cd tasks-for-today
composer install
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
php artisan test
php artisan serve
```

Refresh demo tasks on a later day with `php artisan db:seed --class=TaskSeeder`. Run formatting checks with `vendor/bin/pint --test`. The complete deployment procedure is in the README.

## 8. Submission checklist

- [x] Complete Laravel source and locked dependencies manifest.
- [x] Required schema, Eloquent models, migrations, and registered seeders.
- [x] Eight demo tasks, three dates, four today, exactly one seeded profile.
- [x] Four functional controller routes and consistent Blade views.
- [x] Automated feature tests and local browser checks.
- [x] Setup, database, testing, GitHub, and deployment documentation.
- [x] Secrets, dependency folders, generated caches, and local databases excluded from the source archive and Git staging rules.
- [ ] Replace the clearly marked username/email placeholders with your values.
- [x] Public GitHub repository: https://github.com/MariusKii/it0049-tsa3-tasks-for-today
- [ ] Deploy to your chosen PHP host and verify all four public pages.
- [x] GitHub source URL ready for submission.
- [ ] Submit the live hosted application URL once deployed.

The source repository was created under MariusKii with user authorization. No production deployment was performed. Official Laravel conventions were checked against the documentation linked in README.md.
