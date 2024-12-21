# Building a simplified Admin Panel using Filament PHP
The purpose of this task is to assess your technical expertise, problem-solving abilities, and
familiarity with modern PHP frameworks and libraries. This task-based evaluation will help us
understand your approach to real-world challenges and your ability to deliver high-quality code.

## Requirements
```
PHP 8.1+
Laravel 11
```

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/AvigarD611/filamentphp-laravel-job-task.git
cd filamentphp-laravel-job-task
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Configure the Environment
1. Copy the .env.example file to .env
```bash
cp .env.example .env 
cp .env .env.testing
```

2. Open the .env file and configure your database and other environment variables:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password 
```
Also configure the <code>.env.testing</code> file. This will be required in case you want to run tests 
without breaking your working env

### 4. Generate the Application Key if required
```
php artisan key:generate
```

### 5. Set Up the Database
1. Run the database migrations to create the necessary tables:
```bash
php artisan migrate
php artisan migrate --env=testing
```
2. Seed the database with initial data (roles, users, subscriptions, etc.):
```bash
php artisan db:seed 
```

### 6. Serve the Application
```bash
php artisan serve
```
The application will be available at http://localhost:8000.

### 7. Log In to the Admin Panel
1. Access the FilamentPHP admin dashboard by navigating to:
```
http://localhost:8000/admin
```
2. Role-Based Access: Users with specific roles (e.g., Super Admin, Admin) have access to various dashboard widgets and management tools:

<b>Accounts:</b>
```
Super Admin - superadmin@example.com
Admin - admin@example.com
Editor - editor@example.com
Viewer - viewer@example.com
```
<b>Password</b> for all accounts is:
```password```

### 8. Run tests
```
php artisan test
```
