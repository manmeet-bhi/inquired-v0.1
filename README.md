# Anywhereroles - CMS Based Job Portal

Anywhereroles is a comprehensive, CMS-driven job portal built with Laravel. It serves as a platform connecting job seekers with employers, offering features like job listings, company profiles, user dashboards, and a robust admin management system.

## Features

### For Job Seekers
- **Job Search**: Filter jobs by category, location, salary range, and keywords.
- **Job Details**: View detailed job descriptions, requirements, and company information.
- **User Dashboard**: Track applied jobs, saved jobs, and manage profile.
- **Profile Management**: Create and update professional profiles with skills and experience.

### For Employers
- **Company Profiles**: Create and manage company profiles with branding and information.
- **Job Management**: Post, edit, and manage job listings.
- **Application Tracking**: View and manage applications received for posted jobs.

### Admin Panel
- **User Management**: Manage job seekers and employers.
- **Job Management**: Oversee all job listings on the platform.
- **Category Management**: Create and manage job categories.
- **Settings**: Configure site-wide settings and preferences.
- **Dashboard**: Overview of site statistics and recent activities.

## Tech Stack

- **Framework**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Other**: Laravel Sanctum, Laravel Scout (Algolia)

## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (for frontend assets)

### Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd anywhereroles
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   Copy the `.env.example` file to `.env` and configure your database credentials:
   ```bash
   cp .env.example .env
   ```
   Update `.env` with your database details:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=anywhereroles
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   This will create all the necessary database tables:
   ```bash
   php artisan migrate
   ```

6. **Seed the database (Optional)**
   To populate the database with sample data:
   ```bash
   php artisan db:seed
   ```

7. **Install frontend dependencies**
   ```bash
   npm install
   npm run dev
```
