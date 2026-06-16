# Laravel 13 Admin Management System

A role-based admin management system built with Laravel 13.

This project demonstrates authentication, authorization, user management, media management, activity logging, soft deletes, reusable UI components, and modern Laravel development practices.

## Features

### Authentication

* Login
* Logout
* Registration
* Email Verification
* Password Confirmation

### Authorization

* Role-Based Access Control (RBAC)
* Admin Role
* User Role
* Custom Role Middleware
* User Policies

### User Management

* Create User
* Edit User
* Delete User (Soft Delete)
* Restore User
* Force Delete User
* Change User Password
* Filter Users by Role
* Export Users to Excel

### Media Library

* Upload Files
* View Files
* Delete Files
* User-owned media protection

### Activity Logs

* User Created
* User Updated
* Password Updated
* User Deleted
* User Restored
* User Force Deleted

### UI Features

* Server-side DataTables
* Flash Alerts
* Reusable Confirmation Modal
* Responsive Layout

## Tech Stack

* PHP 8.3
* Laravel 13
* MySQL
* Blade
* Tailwind CSS
* Alpine.js
* jQuery
* DataTables

## Packages

* spatie/laravel-permission
* spatie/laravel-activitylog
* spatie/laravel-medialibrary
* maatwebsite/excel
* yajra/laravel-datatables

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd <project-folder>
```

Install dependencies:

```bash
composer install
npm install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

Create storage link:

```bash
php artisan storage:link
```

Run the application:

```bash
php artisan serve
npm run dev
```

## Demo Account

Admin Account

Email:
[admin@gmail.com](mailto:admin@gmail.com)

Password:
123456789

## Project Structure

* Authentication & Authorization
* User Management
* Media Management
* Activity Logging
* Settings Management

## Future Improvements

* Automated Tests (Pest)
* Dashboard Analytics
* API Authentication
* Multi-Tenant Support
* Notification System
* Audit Report Export

## License

MIT License
