# Sofia Baby Spa — Laravel Template

Clone Baby Spa Web (Next.js) ke Laravel 11 + Sneat theme.
Digunakan sebagai template bisnis baby spa yang dapat di-deploy ke shared hosting PHP.

## Stack
- Laravel 11
- MySQL
- Laravel Sanctum (web session + mobile bearer)
- Spatie Permission (RBAC)
- Sneat Bootstrap UI theme (pink)
- Maatwebsite Excel + DomPDF (export)

## Role
PARENT | THERAPIST | OWNER | ADMIN | RECEPTIONIST | DIREKTUR | SUPER_ADMIN

## Install
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

## API Mobile
Base URL: `/api/v1`
Auth: Bearer token (Sanctum)

## Cron
```bash
* * * * * php /path/to/artisan schedule:run
```

## Deploy Shared Hosting
- Upload semua file kecuali `/vendor` dan `.env`
- `composer install --no-dev` di server
- Set document root ke `/public`
- Isi `.env` dengan kredensial DB + APP_KEY

## GitHub
Repo: buditri777/baby-spa-laravel
Branch: main → production
