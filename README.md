# Laravel Education Portal

This is a full-featured Education Portal project built with Laravel 10.

## Project Structure

The project files have been generated with the following structure:

- **Auth System**: Custom `role` field in Users table for Admin/User distinction.
- **Course System**: Admin management for courses (Title, Description, Price, Thumbnail).
- **Lesson System**: Course content management with video support and ordering.
- **Enrollment**: Users can enroll in courses.
- **Middleware**: `CheckEnrollment` for lesson access and `AdminAccess` for dashboard.
- **Views**: Tailwind CSS styled Blade templates.

## Prerequisites

To run this project, you need:

- **PHP 8.1+**
- **Composer**
- **Node.js & NPM**
- **MySQL Database**

## Installation Steps

Since the current environment does not have PHP/Composer installed, please follow these steps on your local machine:

1.  **Initialize Laravel**:
    The project files provided are the *custom* implementation files. You need to install the core Laravel framework first.
    
    ```bash
    # Create a new Laravel project (if starting from scratch)
    composer create-project laravel/laravel egitim-portali
    
    # OR if you are using the provided files:
    composer install
    ```

2.  **Setup Environment**:
    Copy `.env.example` to `.env` and configure your database.
    
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Run Migrations & Seeders**:
    ```bash
    php artisan migrate --seed
    ```
    *This will create an Admin user: `admin@example.com` / `password`*

4.  **Install Frontend Dependencies**:
    ```bash
    npm install
    npm run dev
    ```

5.  **Serve Application**:
    ```bash
    php artisan serve
    ```

6.  **Access in Browser**:
    Open `http://localhost:8000`

## Note on Docker/Sail

If you prefer using Docker, you can install Laravel Sail:

```bash
php artisan sail:install
./vendor/bin/sail up
```
