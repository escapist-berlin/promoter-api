# Promoter API

## Pre-requisites
- [PHP 8.3 from Laravel Herd](https://herd.laravel.com/)

## Installation
1. Clone the repository to your local machine.
   ```bash
   git clone git@github.com:escapist-berlin/promoter-api.git
   ```
2. Change into the project directory.
   ```bash
   cd promoter-api
   ```
3. Isolate the php version.
   ```bash
   herd isolate php@8.3
   ```
4. Secure the application.
     ```bash
     herd secure
     ```
5. Install the dependencies.
   ```bash
   herd composer install
   ```
6. Set up the SQLite database.
   ```bash
   touch database/database.sqlite
   ```
7. Copy the .env.example file and rename it to .env.
   ```bash
   cp .env.example .env
   ```
   In the .env file, add the absolute path to the SQLite database file:

   ```bash
   DB_DATABASE=/full/path/to/database/database.sqlite
   ```
8. Generate a new application key.
   ```bash
   herd php artisan key:generate
   ```
9. Run the database migrations.
   ```bash
   herd php artisan migrate
   ```
10. Run the database seeders.
     ```bash
     herd php artisan db:seed
     ```
11. Generate the Swagger API documentation.
     ```bash
     herd php artisan l5-swagger:generate
     ```
12. Visit https://promoter-api.test/api/documentation/ in your browser.
13. You can now use the application.

## Helpful tools

- [TablePlus for SQLite debugging](https://tableplus.com/)