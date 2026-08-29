# SCPS Website

This project is a Laravel-based college website with an admin dashboard for managing leadership content, hero slides, faculty, events, news, academic programs, statistics, student voices, facilities, campus information, and site settings.

## Deployment checklist for Hostinger

Use this checklist before going live:

1. Set the production environment values in the server .env file.
2. Make sure the hosting PHP version is 8.3 or newer.
3. Use a MySQL database and set DB_HOST, DB_DATABASE, DB_USERNAME, and DB_PASSWORD.
4. Point the web root to the project public directory or keep the root-level rewrite enabled.
5. Run the Laravel database migrations and admin seeder.
6. Generate the application key and optimize the app for production.

## Required production .env values

```env
APP_NAME=SCPS Website
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

CACHE_STORE=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database
FILESYSTEM_DISK=public
```

## Hostinger deployment steps

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Important notes

- The repository includes a root .htaccess file to route requests into the public folder on shared hosting environments.
- If Hostinger is configured with a custom document root, make sure it points to the project public directory.
- The admin login is available at /admin/login.
- The default seeded administrator login uses the values from the environment variables ADMIN_NAME, ADMIN_EMAIL, and ADMIN_PASSWORD.

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## License

This project is built on Laravel and follows the same MIT-style project structure as the default Laravel application.
