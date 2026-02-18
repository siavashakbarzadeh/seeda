# Seeda — Company CMS

A full-featured corporate website and CMS built with **Laravel 11**, **Filament 3**, and **Tailwind CSS 4**.

## 🚀 Quick Start

```bash
# 1. Install PHP dependencies
composer install

# 2. Install JS/CSS dependencies
npm install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Create database & seed
touch database/database.sqlite      # (or configure MySQL in .env)
php artisan migrate --seed

# 5. Build frontend assets
npm run build                       # (or `npm run dev` for development)

# 6. Start the server
php artisan serve
```

## 📌 Routes

| URL               | Description          |
| ------------------ | -------------------- |
| `/`                | Home page            |
| `/services`        | Services page        |
| `/case-studies`    | Case Studies page    |
| `/about`           | About page           |
| `/contact`         | Contact form         |
| `/admin`           | **CMS Admin Panel**  |

## 🔑 Default Admin

```
Email:    admin@seeda.dev
Password: password
```

## 🏗️ Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **CMS**: Filament 3 (Admin panel with CRUD for Services, Case Studies, Team, Messages)
- **Frontend**: Blade Templates + Tailwind CSS 4.0
- **Database**: SQLite (default) or MySQL
- **Build**: Vite 6

## 📂 Structure

```
seeda/
├── app/
│   ├── Filament/Resources/         # CMS admin resources
│   ├── Http/Controllers/           # Page controller
│   ├── Models/                     # Eloquent models
│   └── Providers/                  # Service providers
├── database/
│   ├── migrations/                 # Database schema
│   └── seeders/                    # Initial data
├── resources/
│   ├── css/app.css                 # Tailwind 4 entry
│   ├── js/app.js                   # Scroll animations + mobile menu
│   └── views/
│       ├── layouts/app.blade.php   # Master layout
│       ├── pages/                  # Page templates
│       └── partials/               # Navbar, Footer, CTA
├── routes/web.php                  # Route definitions
├── composer.json                   # PHP dependencies
├── package.json                    # JS/CSS dependencies
└── vite.config.js                  # Vite + Tailwind config
```

## 🎨 Features

- ✅ Full CMS admin panel (Filament)
- ✅ Dynamic content management (Services, Case Studies, Team Members)
- ✅ Contact form with database storage & admin inbox
- ✅ Scroll reveal & zoom-in animations
- ✅ Responsive mobile design with slide-out menu
- ✅ Glassmorphism navbar
- ✅ Category filtering on Case Studies
- ✅ SEO meta tags per page
- ✅ Deployed anywhere PHP runs (shared hosting, VPS, cloud)
