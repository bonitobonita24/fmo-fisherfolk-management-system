# Development Commands Reference

## 🚀 Quick Start Commands

### Development Server (SQLite - Recommended for Local)
```bash
php artisan serve:dev
```
- Automatically uses SQLite database
- Loads development environment (`.env.development`)
- Debug mode enabled
- Restores production config when stopped

**Custom host/port:**
```bash
php artisan serve:dev --host=0.0.0.0 --port=8080
```

### Production Server (MySQL - For Testing Production)
```bash
php artisan serve
```
- Uses MySQL database
- Loads production environment (`.env`)
- Debug mode disabled

---

## 📦 Database Commands

### Run Migrations (Fresh Install)
```bash
php artisan migrate:fresh --seed
```
Creates all tables and seeds:
- 3 default users (admin, viewer, dataentry)
- 5 sample fisherfolk records
- 16 permission entries

### Run Migrations (Without Seeding)
```bash
php artisan migrate
```

### Rollback Migrations
```bash
php artisan migrate:rollback
```

### Reset Database
```bash
php artisan migrate:fresh
```

### Run Seeders Only
```bash
php artisan db:seed
```

**Specific seeder:**
```bash
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=FisherfolkSeeder
```

---

## 🔐 Default User Accounts

| Email | Password | Role | Permissions |
|-------|----------|------|-------------|
| admin@fmo.gov.ph | password | Super Admin | Full CRUD access (all modules) |
| viewer@fmo.gov.ph | password | Viewer | View-only access (all modules) |
| dataentry@fmo.gov.ph | password | Data Entry | Fisherfolk CRUD only |

---

## 🛠️ Artisan Helper Commands

### Clear All Cache
```bash
php artisan optimize:clear
```
Clears: config, route, view, cache, compiled

### Clear Specific Cache
```bash
php artisan config:clear    # Configuration cache
php artisan route:clear     # Route cache
php artisan view:clear      # Blade view cache
php artisan cache:clear     # Application cache
```

### Create Storage Symlink
```bash
php artisan storage:link
```
Links `storage/app/public` to `public/storage` (for uploaded images)

### List All Routes
```bash
php artisan route:list
```

### Generate Application Key
```bash
php artisan key:generate
```

---

## 📊 Frontend Assets Commands

### Build Assets (Production)
```bash
npm run build
```

### Watch Assets (Development)
```bash
npm run dev
```

### Install Dependencies
```bash
npm install
```

---

## 🗃️ Database Inspection

### Access SQLite Database (Development)
```bash
sqlite3 database/database.sqlite
```

**Useful SQLite commands:**
```sql
.tables                           -- List all tables
.schema fisherfolk                -- Show table structure
SELECT * FROM users;              -- Query users
SELECT * FROM fisherfolk LIMIT 5; -- Query fisherfolk
.exit                             -- Exit SQLite
```

### Access MySQL Database (Production)
```bash
mysql -u fmo_user -p fmo_fisherfolk_management_system
```

**Useful MySQL commands:**
```sql
SHOW TABLES;
DESCRIBE fisherfolk;
SELECT * FROM users;
SELECT COUNT(*) FROM fisherfolk;
EXIT;
```

---

## 🔧 Development Workflow

### 1. Start New Day
```bash
cd /home/me/UbuntuDevFiles/FMO-CalapanCity/FMO-Fisherfolk-Management-System-LARAVEL
php artisan serve:dev
```

### 2. After Pulling Latest Code
```bash
composer install                  # Update PHP dependencies
npm install                       # Update Node dependencies
php artisan migrate               # Run new migrations
php artisan optimize:clear        # Clear all cache
npm run build                     # Build frontend assets
```

### 3. After Changing .env File
```bash
php artisan config:clear
php artisan cache:clear
```

### 4. After Creating New Migration
```bash
php artisan migrate
```

### 5. After Modifying Routes
```bash
php artisan route:clear
```

### 6. After Changing Blade Views
```bash
php artisan view:clear
```

---

## 📝 Code Generation Commands

### Create New Controller
```bash
php artisan make:controller NameController
php artisan make:controller NameController --resource  # With CRUD methods
```

### Create New Model
```bash
php artisan make:model ModelName
php artisan make:model ModelName -m  # With migration
php artisan make:model ModelName -mfc  # With migration, factory, controller
```

### Create New Migration
```bash
php artisan make:migration create_table_name_table
php artisan make:migration add_column_to_table_name
```

### Create New Seeder
```bash
php artisan make:seeder TableNameSeeder
```

### Create New Middleware
```bash
php artisan make:middleware MiddlewareName
```

### Create New Request (Form Validation)
```bash
php artisan make:request RequestName
```

### Create New Command
```bash
php artisan make:command CommandName
```

---

## 🚢 Production Deployment (cPanel)

### 1. Prepare Files
```bash
# Build production assets
npm run build

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Upload to cPanel
- Upload all files via File Manager or FTP
- `.env` is already configured for production (MySQL)
- Just update database credentials in cPanel

### 3. Set Permissions (via cPanel Terminal if available)
```bash
chmod -R 775 storage bootstrap/cache
```

### 4. Run Migrations (via cPanel Terminal if available)
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 5. Create Storage Link (via cPanel Terminal if available)
```bash
php artisan storage:link
```

**Note:** If terminal access is not available in cPanel:
- Database migrations can be run once during initial setup
- See `PRODUCTION_SETUP.md` for alternatives

---

## 🔍 Troubleshooting Commands

### Check Application Status
```bash
php artisan about
```

### Test Database Connection
```bash
php artisan tinker
```
Then in tinker:
```php
DB::connection()->getPdo();  // Test connection
User::count();               // Count users
exit
```

### Fix Permissions (Linux/Mac)
```bash
sudo chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### Reset Everything
```bash
php artisan optimize:clear
php artisan migrate:fresh --seed
php artisan storage:link
npm run build
```

---

## 📚 Useful Aliases (Optional)

Add to `~/.zshrc` or `~/.bashrc`:

```bash
alias art="php artisan"
alias artisan="php artisan"
alias serve="php artisan serve:dev"
alias migrate="php artisan migrate"
alias fresh="php artisan migrate:fresh --seed"
alias tinker="php artisan tinker"
```

Then reload:
```bash
source ~/.zshrc
```

---

## 🌐 Application URLs

- **Development:** http://localhost:8000
- **Dashboard:** http://localhost:8000/dashboard
- **Fisherfolk List:** http://localhost:8000/fisherfolk
- **Login:** http://localhost:8000/login

---

## 📖 Related Documentation

- `README.md` - Main project documentation
- `PRODUCTION_SETUP.md` - MySQL production deployment guide
- `.env.development` - Development environment config
- `.env` - Production environment config (default)

---

## ⚡ Pro Tips

1. **Always use `serve:dev`** for local development - it handles environment switching automatically
2. **Clear cache** after changing config files or routes
3. **Run migrations** in fresh environments to set up database
4. **Use tinker** for quick database queries and testing
5. **Build assets** before deploying to production
6. **Never commit** `.env` file to Git (use `.env.example`)

---

**Last Updated:** December 5, 2025
