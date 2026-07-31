# Kanka Agent Guide

## Runtime and Setup

- This is a PHP 8.4 Laravel 13 application using Pest 4, Vue, Vite, and Yarn.
- Local development runs in Laravel Sail. Start services with `vendor/bin/sail up -d`; run PHP, Composer, Artisan, and Node commands through `vendor/bin/sail`.
- The Sail stack includes MariaDB, Redis, MinIO, Thumbor, Mailpit, and Meilisearch. See `docs/running.md` for the initial dependency-install command and environment setup.
- Initial setup order is: configure `.env`, start Sail, create public MinIO buckets named `kanka` and `thumbnails`, run `vendor/bin/sail artisan kanka:install`, then run `vendor/bin/sail artisan setup:meilisearch`.

## Commands

- Run focused tests with `vendor/bin/sail artisan test --compact <test-path>` or `vendor/bin/sail artisan test --compact --filter=<test-name>`.
- Feature tests use in-memory SQLite, `RefreshDatabase`, a null Scout driver, and no logs database. Campaign tests commonly need the helpers `->asUser()->withCampaign()` from `tests/TestCase.php`.
- Format changed PHP files with `vendor/bin/sail bin pint --dirty --format agent`.
- Run PHPStan with `vendor/bin/sail composer run test:types`.
- Run the frontend dev server with `vendor/bin/sail yarn dev`; build production assets with `vendor/bin/sail yarn build`. The build removes replaced files under `public/build/`, so commit intentional generated asset changes.

## Application Boundaries

- Application wiring is split across `bootstrap/app.php`, `app/Http/Kernel.php`, and `app/Providers/RouteServiceProvider.php`; preserve this structure when adding middleware, providers, or routes.
- Campaign UI routes live in `routes/campaigns/*.php` under `/w/{campaign}`. The route binding uses `Campaign::acl()`, so preserve ACL-scoped campaign resolution.
- API v1 routes are under `/api/1.0`, use Passport authentication and rate limiting, and public API routes are separate under `/api/public`.
- Model observers are registered for web requests and unit tests but skipped for normal console and queue commands. Do not rely on observer side effects in Artisan commands or jobs.
- Production uses MariaDB while tests use SQLite. Preserve existing driver-specific migration handling and do not assume SQLite exercises MariaDB SQL or foreign-key behavior.

## Conventions

- Use `__()` for user-facing text; translations are maintained separately from English development.
- Prefer existing route, controller, model, factory, and test patterns before introducing new structure.
