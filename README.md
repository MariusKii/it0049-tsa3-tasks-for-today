# Tasks for Today Management System

A responsive Laravel application for viewing today's tasks, exploring the full schedule, and displaying a database-backed profile. Built for **IT0049 – Web System Technologies, Technical Summative Assessment 3** by **Marius De Asis**.

The application has four public, read-only pages. It uses controllers, Eloquent models, migrations, seeders, and a shared Blade layout. No login or task modification workflow is required by this assessment.

## Requirements

- PHP **8.4.1 or later** (the locked Symfony dependencies require this; verified on PHP 8.5.10).
- Composer 2 (verified on 2.10.3).
- PHP extensions required by Laravel, including PDO, pdo_sqlite, mbstring, ctype, curl, dom, fileinfo, filter, hash, openssl, session, tokenizer, and XML. Run `composer check-platform-reqs` after installation.
- SQLite, included through the PHP SQLite extensions. MySQL is also configurable.
- No Node.js, npm, frontend build process, external font service, or CDN is needed. CSS and SVG icons are served locally.

The installed framework is Laravel **13.42.0**, locked in `composer.lock`.

## Install from a clone or the source ZIP

Repository: [https://github.com/MariusKii/it0049-tsa3-tasks-for-today](https://github.com/MariusKii/it0049-tsa3-tasks-for-today). Clone it with the command below, or extract the source ZIP. The ZIP contains a top-level `tasks-for-today` directory.

```sh
git clone https://github.com/MariusKii/it0049-tsa3-tasks-for-today.git tasks-for-today
```

```sh
cd tasks-for-today
composer install
cp .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
php artisan serve
```

Open **http://127.0.0.1:8000**. If the port is occupied, use `php artisan serve --port=8053` and open **http://127.0.0.1:8053**.

For this already prepared local working copy, dependencies, the local environment, and the seeded SQLite database are present. Just run `php artisan serve`. Do not replace an existing `.env` or regenerate an existing application key unnecessarily.

On a fresh clone, `composer setup` is an alternative to the installation commands after entering the project directory. It installs dependencies, creates `.env` only if absent, generates an application key, creates SQLite if absent, and runs migrations with seeders. Use that convenience command only for initial setup because it generates a new key.

## Environment configuration

The committed `.env.example` contains these development defaults:

```dotenv
APP_NAME="Tasks for Today Management System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_TIMEZONE=Asia/Manila
DB_CONNECTION=sqlite
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Leave `DB_DATABASE` unset for the default `database/database.sqlite` file. An absolute SQLite database path may be supplied through `DB_DATABASE`. The application timezone controls both seeding and today's query. Run `php artisan config:clear` after changing configuration locally.

For MySQL, create an empty dedicated database and configure `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the local environment. Then run migrations and seeders. MySQL deployment was not executed in the development verification.

Never commit `.env`, database files, application keys, or credentials. `.gitignore` excludes them. The source archive contains `.env.example` with an empty key.

## Database schema

| Table | Columns |
| --- | --- |
| `tasks` | `id` (auto-increment primary key), `title` (string), `status` (string, database default `pending`), `task_date` (date), `created_at`, `updated_at` |
| `users` | `id` (auto-increment primary key), `username` (unique string), `full_name` (string), `email` (string), `created_at`, `updated_at` |

Laravel also creates its internal `migrations` bookkeeping table. No password, session, job, or cache tables are needed. File sessions/cache and synchronous queues avoid extra database tables. `User` is an Eloquent profile model with no authentication workflow.

Migrations match the provided assessment fields. Original TSA1 files were not supplied, so those fields are the baseline.

```sh
php artisan migrate
php artisan db:seed
php artisan migrate:status
```

No destructive reset is needed. Avoid `migrate:fresh` or `db:wipe` on a database with records you want to preserve. Tests use a separate in-memory SQLite database.

## Seed data

`DatabaseSeeder` registers `TaskSeeder` and `UserSeeder`. On a fresh database, they insert **8 tasks across 3 dates** and **exactly 1 profile**.

| Task | Date relative to seeding day | Status |
| --- | --- | --- |
| Review PHP fundamentals | Yesterday | Completed |
| Complete database migration | Yesterday | Completed |
| Review Laravel documentation | Today | Completed |
| Study Eloquent relationships | Today | Pending |
| Submit laboratory requirements | Today | Pending |
| Test application routes | Today | Completed |
| Prepare project documentation | Tomorrow | Pending |
| Finalize GitHub repository | Tomorrow | Pending |

Dates come from `today(config('app.timezone'))`, not hardcoded calendar dates. Seeders never run automatically during page requests. To refresh the demonstration for a later presentation day, run:

```sh
php artisan db:seed --class=TaskSeeder
```

Task seeding identifies the eight demo tasks by their stable titles and updates their dates/statuses when rerun; it does not add duplicates or delete unrelated tasks. Because these are demo records, rerunning intentionally resets their sample statuses and reschedules them around the current date. Renaming a sample title causes that original sample title to be inserted again on the next seed.

The profile uses **Marius De Asis**, username **CHANGE_ME**, and email **change-me@example.invalid**. Username and email are clearly marked editable placeholders; no personal address was invented. Before first seeding a new database, change them in `database/seeders/UserSeeder.php`. To update the existing local profile:

```sh
php artisan tinker
```

Then enter an Eloquent update with your own actual values:

```php
$user = App\Models\User::firstOrFail();
$user->update(['username' => 'YOUR_USERNAME', 'email' => 'YOUR_EMAIL']);
```

The strings in that example are placeholders. Use your own values. Profile details are rendered from the database, not hardcoded in Blade. The profile seeder preserves any existing profile and edited values. If more than one user already exists, it warns and preserves the records; the fresh-database exact-one requirement then needs manual review. It never deletes users.

## Routes and behavior

| Method | Path | Route name | Controller | Behavior |
| --- | --- | --- | --- | --- |
| GET | `/` | `dashboard` | `WelcomeController@index` | Only today's tasks; total, pending, completed counts and progress |
| GET | `/tasks` | `tasks.index` | `TaskController@index` | Every task ordered by date ascending, then ID |
| GET | `/profile` | `profile` | `ProfileController@index` | First database profile by ID; graceful missing-profile state |
| GET | `/about` | `about` | `AboutController@index` | Static developer, course, assessment, and technology information |

`WelcomeController` uses `Task::whereDate('task_date', $today)`. `TaskController` retrieves all records through Eloquent. Controllers pass data to Blade, and templates perform no database queries. `Task` casts `task_date` as a date. Both models configure mass-assignable fields.

All pages share the layout, navigation with active-page indicators, branding, and footer. Tables scroll horizontally on narrow screens; navigation switches to a compact horizontal layout. Empty states, escaped text, visible focus styles, a skip link, semantic headings, and text status labels are included.

## Important project files

```text
app/
  Http/Controllers/
    WelcomeController.php
    TaskController.php
    ProfileController.php
    AboutController.php
  Models/
    Task.php
    User.php
config/app.php                      Application name and timezone
routes/web.php                      Four named controller routes
database/
  migrations/
    0001_01_01_000000_create_users_table.php
    0001_01_01_000001_create_tasks_table.php
  seeders/
    DatabaseSeeder.php
    TaskSeeder.php
    UserSeeder.php
  factories/                        Test fixtures
resources/views/
  layouts/app.blade.php              Shared layout
  components/icon.blade.php          Local SVG icons
  components/task-table.blade.php    Reused task table and empty state
  welcome.blade.php
  tasks/index.blade.php
  profile.blade.php
  about.blade.php
public/css/app.css                   Responsive styles
public/favicon.svg
tests/Feature/TaskManagementTest.php
phpunit.xml                         In-memory test database
composer.json
composer.lock
.env.example
```

## Testing

```sh
php artisan test
vendor/bin/pint --test
php artisan route:list --except-vendor
php artisan view:cache
composer check-platform-reqs
```

Verified locally and again from a clean source-archive installation: **17 tests passed, 76 assertions**. Coverage includes loading all pages, today's inclusion and past/future exclusion, the Manila/UTC calendar boundary, task ordering, profile retrieval and absence, About content, shared layout, seed counts/date distribution, repeat seeding on another day, preservation of unrelated records and edited profiles, the database default status, unique username constraint, date casting, and HTML escaping.

All four pages were inspected in the browser. The dashboard was additionally inspected at 1280px desktop and 390px mobile iframe viewport widths, and at the browser's 660px width. These were visual spot checks, not an exhaustive browser compatibility audit.

## GitHub submission

Public source repository: [https://github.com/MariusKii/it0049-tsa3-tasks-for-today](https://github.com/MariusKii/it0049-tsa3-tasks-for-today).

The repository includes the Laravel source, `composer.lock`, migrations, seeders, tests, and setup documentation. `.env`, local SQLite files, `vendor/`, generated logs, and compiled views are excluded by `.gitignore`.

Submit this GitHub repository URL for the source-code requirement. The assessment also requires a separate **live hosted application URL**. GitHub stores the source; this PHP application needs a PHP-capable host to run.

To publish future reviewed changes from a clone:

```sh
git add .
git diff --cached --name-only
git commit -m "Describe your update"
git push origin main
```

Inspect staged files before committing so credentials and local data remain private.

## Deployment

Use a host supporting PHP 8.4.1+ and Composer, with HTTPS and a persistent disk or managed SQL database. Follow the official [Laravel deployment documentation](https://laravel.com/docs/13.x/deployment).

1. Deploy the reviewed source or clone your actual repository on the server.
2. Set the web document root to **the project's `public/` directory**, never the repository root.
3. Run `composer install --no-dev --optimize-autoloader`.
4. Create a production environment using the host's environment settings or a private `.env` file. Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` to your actual HTTPS URL, and `APP_TIMEZONE=Asia/Manila`. Configure the database and the file/sync drivers shown above.
5. Generate the production application key once with `php artisan key:generate`. Preserve this key on subsequent deployments; keep credentials outside Git.
6. For SQLite, create a persistent database file, set `DB_DATABASE` to its absolute path, and grant the web process write access to the database and its containing directory. A disposable deployment filesystem will lose data; use persistent storage or MySQL instead.
7. Grant the web process write access to `storage/` and `bootstrap/cache/` without making the repository broadly writable.
8. On the intended fresh TSA3 production database, run `php artisan migrate --force` and `php artisan db:seed --force`. On future deployments, run pending migrations; seed again only when you intend to reset the sample tasks around today's date.
9. Run `php artisan optimize`. Do not use the Artisan development server as the public production server. No npm build or queue worker is necessary for this application.
10. Visit `/`, `/tasks`, `/profile`, and `/about` through the actual hosted HTTPS URL. Check today's date, counts, profile values, CSS, and mobile navigation. Submit that working URL together with GitHub.

The source repository is public under MariusKii. Production hosting has not been performed. The local preview is not a hosted submission URL.

## Official references

Implementation conventions were checked against the official [Laravel installation](https://laravel.com/docs/13.x/installation), [Eloquent](https://laravel.com/docs/13.x/eloquent), [seeding](https://laravel.com/docs/13.x/seeding), and [database testing](https://laravel.com/docs/13.x/database-testing) documentation. Assessment requirements came from the supplied IT0049 TSA3 activity document; the pasted master prompt supplied the implementation request.
