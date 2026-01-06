# Laravel + PostgreSQL Demo

A simple Laravel application that displays quotes from a PostgreSQL database. Built to test Render.com's deployment services.

## Features

- 🚀 Laravel 11 framework
- 🐘 PostgreSQL database integration
- 📊 Database connection status display
- 💬 Sample quotes from the database
- 🎨 Modern, responsive UI

## Local Development

### Prerequisites

- PHP 8.2+
- Composer
- PostgreSQL

### Setup

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd simple-laravel
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update `.env` with your PostgreSQL credentials**
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seed the database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. Visit `http://localhost:8000`

## Deploy to Render.com

### Option 1: Blueprint Deployment (Recommended)

1. **Push this repo to GitHub**

2. **Create a new Blueprint on Render**
   - Go to [Render Dashboard](https://dashboard.render.com/)
   - Click "New" → "Blueprint"
   - Connect your GitHub repository
   - Render will automatically detect the `render.yaml` file

3. **Deploy!**
   - Render will create both the web service and PostgreSQL database
   - Environment variables are configured automatically

### Option 2: Manual Deployment

1. **Create a PostgreSQL database on Render**
   - Dashboard → New → PostgreSQL
   - Copy the "External Database URL"

2. **Create a Web Service**
   - Dashboard → New → Web Service
   - Connect your repository
   - Configure:
     - **Runtime**: PHP
     - **Build Command**: `./scripts/render-build.sh`
     - **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

3. **Set Environment Variables**
   ```
   APP_NAME=Laravel Demo
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=<generate with: php artisan key:generate --show>
   APP_URL=https://your-app.onrender.com
   
   DB_CONNECTION=pgsql
   DATABASE_URL=<your-render-postgres-url>
   
   LOG_CHANNEL=stderr
   SESSION_DRIVER=cookie
   CACHE_STORE=file
   ```

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   └── HomeController.php    # Main controller
│   └── Models/
│       └── Quote.php             # Quote model
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/
│       └── QuoteSeeder.php       # Sample data seeder
├── resources/views/
│   └── home.blade.php            # Homepage template
├── routes/
│   └── web.php                   # Web routes
├── scripts/
│   └── render-build.sh           # Render build script
├── render.yaml                   # Render Blueprint config
└── Procfile                      # Process file for deployment
```

## Tech Stack

- **Framework**: Laravel 11
- **Database**: PostgreSQL
- **Hosting**: Render.com
- **PHP**: 8.2+

## License

MIT License
