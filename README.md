# phptframework

phptframework - Pure framework replacement

(phptframework) provides the core router, templates, models and a starting blog structure (Markdown posts, comments, admin panel).
- How to install and run (on your machine): see below.

Install & Run (summary)
- Clone the external repo (your own): git clone git@github.com:themhz/myframework.git
- Apply patch phptframework-replace.patch (provided in this patch program) or run the patch plan described in the PR.
- After patch is applied, push with force to main: git push -f origin main
- Run docker-compose (inside phptframework dir) to boot the stack:
  docker-compose up -d --build
- Access the app: http://localhost/

Project layout (highlights)
- phptframework/app: core framework (Website, Router, Language, Markdown support, models)
- phptframework/docker-compose.yml and phptframework/Dockerfile to run a PHP-Apache stack
- phptframework/app/install/db_init.sql for initial schema
- phptframework/app/models: Posts, Users, Comments
- phptframework/app/endpoints/public: blog, posts, home, post
- phptframework/app/endpoints/private: admin pages

Note: This README will be updated after the patch with exact steps and commands for your environment.
