# Fisherfolk Management System - Laravel 12

A comprehensive data visualization and management system for tracking fisherfolk in Calapan City. Built with Laravel 12, Tailwind CSS, Chart.js, and MySQL.

## 🚀 Quick Start

**Current Project Status:** ✅ Foundation Complete - Ready for Database Setup

### What's Been Implemented:

✅ Laravel 12 application structure  
✅ Laravel Breeze authentication with Tailwind CSS  
✅ Database migrations (users, fisherfolk, permissions)  
✅ Eloquent models with relationships  
✅ Permission-based middleware system  
✅ Dashboard with Chart.js integration  
✅ Fisherfolk CRUD controller and views  
✅ API endpoints for statistics  
✅ Frontend assets built and compiled  

### Next Steps:

1. **Configure Database** - Set up MySQL credentials in `.env`
2. **Run Migrations** - Create database tables and seed initial data
3. **Start Development** - Launch the application

---

## 📋 System Requirements

- PHP 8.2 or higher
- Composer 2.x
- MySQL 8.0 or higher
- Node.js 18+ & NPM

---

## 🛠️ Setup Instructions

### Step 1: Configure Database

**⚠️ Important:** This project is configured for **production by default** (perfect for cPanel shared hosting).

**Default Configuration (Production - MySQL):**

The `.env` file is already set to MySQL. Just update your credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fmo_fisherfolk_management_system
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password
```

**For Local Development (SQLite):**

Use the development server command (see Step 3) - it automatically switches to SQLite:

```bash
php artisan serve:dev
```

📖 **See [PRODUCTION_SETUP.md](PRODUCTION_SETUP.md) for complete MySQL setup guide**

### Step 2: Run Migrations & Seeders

**For Production (MySQL):**

```bash
php artisan migrate:fresh --seed
```

**For Development (SQLite):**

No need to run migrations manually - the `serve:dev` command handles the SQLite database automatically.

This creates:
- ✅ Database tables (users, fisherfolk, permissions)
- ✅ Admin user: `admin@fmo.gov.ph` / `password`
- ✅ Viewer user: `viewer@fmo.gov.ph` / `password`
- ✅ Data Entry user: `dataentry@fmo.gov.ph` / `password`
- ✅ Sample fisherfolk records
- ✅ Permission matrix for all users

### Step 3: Start the Application

**For Local Development (SQLite - Recommended):**

```bash
php artisan serve:dev
```

This automatically:
- ✅ Switches to SQLite database (no MySQL needed)
- ✅ Loads `.env.development` settings
- ✅ Sets debug mode and local environment
- ✅ Restores production config when stopped

**For Production Testing (MySQL):**

```bash
php artisan serve
```

**Custom host/port:**
```bash
php artisan serve:dev --host=0.0.0.0 --port=8080
```

Visit: **http://localhost:8000**

Login with: `admin@fmo.gov.ph` / `password`

---

## 👥 Default User Accounts

| Email | Password | Permissions |
|-------|----------|-------------|
| admin@fmo.gov.ph | password | ✅ Full access (Super Admin) |
| viewer@fmo.gov.ph | password | 👁️ View-only access |
| dataentry@fmo.gov.ph | password | ✏️ Can add/edit fisherfolk |

---

## 🎯 Features

### 📊 Dashboard
- Summary statistics cards (total fisherfolk, gender distribution, barangays)
- Interactive Chart.js visualizations:
  - Barangay distribution (horizontal bar chart)
  - Gender distribution (doughnut chart)
  - Age group distribution (bar chart)
  - Activity categories (horizontal bar chart)
- Recently registered fisherfolk table

### 👥 Fisherfolk Management
- Full CRUD operations (Create, Read, Update, Delete)
- Search by name or ID number
- Filter by barangay and gender
- Image and signature upload
- Multiple activity categories per record
- Pagination (15 records per page)

### 🔒 Permission System
- Granular CRUD permissions per module
- Permission-based route protection
- Middleware: `permission:module.action`
- Modules: dashboard, fisherfolk, users, reports, import, settings

### 🔌 RESTful API
- `/api/stats/summary` - Overall statistics
- `/api/stats/barangay` - Fisherfolk per barangay
- `/api/stats/gender` - Gender distribution
- `/api/stats/age-group` - Age groups
- `/api/stats/category` - Activity categories

---

## 🎨 Design System

**Maritime Color Scheme:**
- Primary Blue: `#0000FF`
- Orange Accent: `#FFA500`
- Ocean Blue: `#0066CC`
- Sunset Orange: `#FF8C00`

**UI Framework:** Tailwind CSS 3+  
**Icons:** Heroicons  
**Charts:** Chart.js 4.4  
**Frontend:** Alpine.js + Vite  

---

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php      ← Dashboard stats
│   │   │   ├── FisherfolkController.php     ← CRUD operations
│   │   │   └── Api/
│   │   │       └── StatsController.php      ← API endpoints
│   │   └── Middleware/
│   │       └── CheckPermission.php          ← Permission middleware
│   └── Models/
│       ├── User.php                         ← User model with permissions
│       ├── Fisherfolk.php                   ← Fisherfolk model
│       └── Permission.php                   ← Permission model
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_users_table.php
│   │   ├── xxxx_create_fisherfolk_table.php
│   │   └── xxxx_create_permissions_table.php
│   └── seeders/
│       ├── UserSeeder.php                   ← Creates default users
│       └── FisherfolkSeeder.php             ← Sample data
│
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php              ← Dashboard with charts
│   │   └── fisherfolk/
│   │       └── index.blade.php              ← Fisherfolk list
│   └── js/
│       ├── app.js                           ← Main JS entry
│       └── charts.js                        ← Chart.js initialization
│
├── routes/
│   ├── web.php                              ← Web routes
│   └── api.php                              ← API routes
│
└── storage/
    └── app/
        └── public/
            └── uploads/                     ← Fisherfolk images
```

---

## 🗄️ Database Schema

### Fisherfolk Table
```sql
id_number (VARCHAR 50, PRIMARY KEY)
full_name (VARCHAR 255)
date_of_birth (DATE)
address (VARCHAR 255)              -- Barangay name
sex (ENUM: 'Male', 'Female')
image (VARCHAR 255)                -- Filename only
signature (VARCHAR 255)            -- Filename only
rsbsa (VARCHAR 50)
contact_number (VARCHAR 20)
boat_owneroperator (BOOLEAN)
capture_fishing (BOOLEAN)
gleaning (BOOLEAN)
vendor (BOOLEAN)
fish_processing (BOOLEAN)
aquaculture (BOOLEAN)
date_registered (TIMESTAMP)
date_updated (TIMESTAMP)
```

### Permissions Table
```sql
id (BIGINT)
user_id (BIGINT, FOREIGN KEY → users.id)
module (VARCHAR 50)
can_create (BOOLEAN)
can_view (BOOLEAN)
can_update (BOOLEAN)
can_delete (BOOLEAN)
UNIQUE(user_id, module)
```

---

## 🚀 Development Commands

```bash
# Start development server
php artisan serve
npm run dev

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Rebuild assets
npm run build

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Fresh migration with seed
php artisan migrate:fresh --seed
```

---

## 🐛 Troubleshooting

### Database Connection Failed
1. Check MySQL is running: `sudo systemctl status mysql`
2. Verify credentials in `.env`
3. Ensure database exists: `SHOW DATABASES;`

### Images Not Displaying
```bash
php artisan storage:link
chmod -R 775 storage/app/public/uploads
```

### Charts Not Loading
```bash
npm run build
# Clear browser cache
```

### Permission Denied (403)
1. Check user permissions in database
2. Clear config: `php artisan config:clear`
3. Log in with admin@fmo.gov.ph

---

## 📝 Important Notes

⚠️ **File Extensions:** Case-sensitive on Linux! Database stores `.JPG` (uppercase), files must match exactly.

⚠️ **Primary Key:** `id_number` is VARCHAR, not auto-increment INT.

⚠️ **Multiple Categories:** A fisherfolk can have multiple activity categories simultaneously.

⚠️ **Image Storage:** Files stored in `storage/app/public/uploads/`, accessed via `/storage/uploads/`.

---

## 🔒 Security

- ✅ CSRF protection (Laravel default)
- ✅ XSS prevention (Blade escaping)
- ✅ SQL injection protection (Eloquent ORM)
- ✅ Permission-based access control
- ✅ Password hashing (bcrypt)
- ✅ Session-based authentication

---

## 📊 System Modules

| Module | Create | View | Update | Delete |
|--------|--------|------|--------|--------|
| Dashboard | - | ✅ | - | - |
| Fisherfolk | ✅ | ✅ | ✅ | ✅ |
| Users | ✅ | ✅ | ✅ | ✅ |
| Reports | ✅ | ✅ | - | - |
| Import | ✅ | ✅ | - | - |
| Settings | - | ✅ | ✅ | - |

---

## 👨‍💻 Developer Information

**Developer:** Powerbyte IT Solutions  
**Client:** Calapan City Fisheries Management Office (FMO)  
**Framework:** Laravel 12.41.1  
**PHP Version:** 8.2+  
**Database:** MySQL 8.0+  
**Frontend:** Tailwind CSS 3, Chart.js 4.4, Alpine.js  

---

## 📅 Version History

**Version 1.0.0** - December 4, 2025
- ✅ Initial Laravel 12 implementation
- ✅ Authentication with Laravel Breeze
- ✅ Permission system
- ✅ Dashboard with Chart.js
- ✅ Fisherfolk CRUD
- ✅ API endpoints
- ✅ Responsive Tailwind design

---

## 🎓 Next Development Phase

**Phase 2 - User Management:**
- [ ] User CRUD interface
- [ ] Permission matrix UI
- [ ] Role templates
- [ ] User activity logging

**Phase 3 - Advanced Features:**
- [ ] CSV import functionality
- [ ] Export reports (PDF/Excel)
- [ ] Advanced search/filtering
- [ ] Barangay-category analysis

**Phase 4 - Production:**
- [ ] Production deployment
- [ ] Performance optimization
- [ ] Security hardening
- [ ] User acceptance testing

---

**For questions or support, contact: Powerbyte IT Solutions**
