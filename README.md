# inaquired - CMS Based Job Portal

inaquired is a comprehensive, CMS-driven job portal built with Laravel. It serves as a platform connecting job seekers with employers, offering features like job listings, company profiles, user dashboards, and a robust admin management system.

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

- **Framework**: Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Authentication**: Laravel Session & 2FA
- **Storage**: Cloudflare R2 / Local

## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL (XAMPP / Standalone)
- Node.js & NPM (for frontend assets)

### Steps

1. **Configure environment**
   Ensure `.env` is configured with your database credentials:
   ```env
   APP_NAME=inaquired
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=anywhereroles
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Install dependencies**
   ```bash
   php composer.phar install
   npm install
   npm run build
   ```

3. **Run migrations (if needed)**
   ```bash
   php artisan migrate
   ```

4. **Start Development Server**
   ```bash
   php artisan serve
   ```
