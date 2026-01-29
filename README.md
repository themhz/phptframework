# phptframework

phptframework is a small, Docker-first PHP 8 project that bundles a lightweight framework core (routing, templates, models, helpers) together with a starter blog application (Markdown posts + comments) and an admin area.

It is intentionally minimal and file-based: controllers live in the filesystem, models are simple PHP classes, and the runtime is a plain Apache + mod_rewrite container.

## What's included

- Apache routing via `.htaccess` to a single front controller (`app/index.php`)
- A router component that can map URLs like `/page/method/id` and `/admin/...` to controllers (`app/components/Router.php`)
- Public and private (admin) templates (`app/endpoints/public/template`, `app/endpoints/private/template`)
- Starter pages for home/blog/post/login/logout, plus 403/404 handlers
- Basic auth guard for admin routes (session-based)
- Markdown rendering via `league/commonmark`
- Environment config via `vlucas/phpdotenv` (`app/.env.example`)
- MySQL schema for users/posts/comments (`app/install/db_init.sql`)

## Quick start (Docker)

1) Create your env file:

```bash
cp app/.env.example app/.env
```

2) Build and start the stack:

```bash
docker-compose up -d --build
```

3) Open:

- App: `http://localhost/`
- MySQL (host port): `127.0.0.1:3308` (container port 3306)

## Database setup

This repo includes a basic schema at `app/install/db_init.sql`.

One simple way to apply it:

```bash
docker exec -i phptframework-db mysql -uroot -prootpassword phptframework < app/install/db_init.sql
```

## Create an admin user

After the schema exists and the app is configured, you can create an admin user via:

```bash
docker exec -it phptframework-web php scripts/create_admin.php email=you@example.com password=yourpassword
```

## How requests are structured

- Entry point: `app/index.php`
- Rewrite rules: `app/.htaccess` routes everything to the entry point
- Routing logic (available): `app/components/Router.php`
- Pages:
  - Public: `app/endpoints/public/pages/<page>/Controller.php`
  - Admin: `app/endpoints/private/pages/<page>/Controller.php` (mounted under `/admin/...`)
- Templates:
  - Public: `app/endpoints/public/template/index.php`
  - Admin: `app/endpoints/private/template/index.php`

Note: the project includes both older and newer framework components; if you are extending routing/bootstrapping, start by reviewing `app/components/Website.php` and `app/components/Router.php` and wiring the flow you want.

## Configuration

Copy `app/.env.example` to `app/.env` and adjust as needed:

- `DEFAULT_PAGE`, `DEFAULT_METHOD`
- `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`

`app/.env` is intentionally ignored by git.
