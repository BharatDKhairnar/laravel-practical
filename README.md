

**Please Note:** There is a mailtrap account in progress for domain verification so at the time of email verification check there is a chance to stop the ongoing process so You should change the email credentials on the .env file from your side.


# Laravel-Admin | Laravel 9.1 

Laravel-Admin is Admin Panel With Multi tenat DB concept and update the Profile.


## Tech Stack

**Client:** HTML, CSS, JavaScript, jQuery

**Server:** PHP 8.0, Laravel 9.1.0

**DataBase:** MySql


## Installation

Install Laravel-Admin With Simple Steps

```bash
git clone https://github.com/BharatDKhairnar/laravel-practical.git
cd laravel-practical
```

Install All Packages of laravel
```bash
composer install
```

Install NPM Dependencies
```bash
npm install && npm run dev
```

Create .env file
```bash
cp .env.example .env
```

Generate Application key

```bash
php artisan key:generate
```

Update .env File with Database credentials and run migration with seed.
```bash
php artisan migrate --seed
```

App URL
```bash
http://laravel-test.local/login
OR
http://127.0.0.1:8000/login
```

Company Register URL
```bash
http://laravel-test.local/companies/create
OR
http://127.0.0.1:8000/login/companies/create
```

Login With Super Admin
```bash
Username - admin@admin.com
Password - Admin@123
```
## Screenshots

You can check the screenshot of practical in screenshots folder.

## Feedback

If you have any feedback, please reach out to me at bharatdkhairanr@gmail.com

