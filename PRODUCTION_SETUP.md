# Production Deployment Guide

## 🚀 MySQL Production Setup

### Step 1: Install MySQL on Production Server

```bash
sudo apt update
sudo apt install mysql-server -y
sudo systemctl start mysql
sudo systemctl enable mysql
```

### Step 2: Secure MySQL Installation

```bash
sudo mysql_secure_installation
```

Follow prompts:
- Set root password
- Remove anonymous users: Yes
- Disallow root login remotely: Yes
- Remove test database: Yes
- Reload privilege tables: Yes

### Step 3: Create Database and User

```bash
sudo mysql -u root -p
```

Then run these SQL commands:

```sql
-- Create database
CREATE DATABASE fmo_fisherfolk_management_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create dedicated user
CREATE USER 'fmo_user'@'localhost' IDENTIFIED BY 'your_secure_password_here';

-- Grant privileges
GRANT ALL PRIVILEGES ON fmo_fisherfolk_management_system.* TO 'fmo_user'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;

-- Verify
SHOW DATABASES;
SELECT User, Host FROM mysql.user WHERE User = 'fmo_user';

EXIT;
```

### Step 4: Configure Laravel for MySQL

1. Copy production environment file:
```bash
cp .env.production .env
```

2. Edit `.env` file:
```bash
nano .env
```

3. Update these values:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fmo_fisherfolk_management_system
DB_USERNAME=fmo_user
DB_PASSWORD=your_secure_password_here
```

4. Generate new application key:
```bash
php artisan key:generate
```

### Step 5: Run Migrations

```bash
# Run migrations
php artisan migrate --force

# Seed database with initial users
php artisan db:seed --class=UserSeeder --force

# Or run all seeders
php artisan db:seed --force
```

### Step 6: Optimize for Production

```bash
# Build frontend assets
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Create storage symlink
php artisan storage:link
```

---

## 🔄 Switching Between Environments

### Development (SQLite):
```bash
# .env file
DB_CONNECTION=sqlite
```

### Production (MySQL):
```bash
# .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fmo_fisherfolk_management_system
DB_USERNAME=fmo_user
DB_PASSWORD=your_password
```

---

## 🗄️ MySQL Backup & Restore

### Backup Database:
```bash
mysqldump -u fmo_user -p fmo_fisherfolk_management_system > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore Database:
```bash
mysql -u fmo_user -p fmo_fisherfolk_management_system < backup_20251205_120000.sql
```

### Automated Daily Backups:
```bash
# Create backup script
nano /home/your_user/backup_fmo_db.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/home/your_user/backups"
DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p $BACKUP_DIR
mysqldump -u fmo_user -p'your_password' fmo_fisherfolk_management_system > $BACKUP_DIR/fmo_backup_$DATE.sql
# Keep only last 30 days
find $BACKUP_DIR -name "fmo_backup_*.sql" -mtime +30 -delete
```

```bash
# Make executable
chmod +x /home/your_user/backup_fmo_db.sh

# Add to crontab (daily at 2 AM)
crontab -e
# Add this line:
0 2 * * * /home/your_user/backup_fmo_db.sh
```

---

## 🌐 Web Server Configuration

### Apache Configuration

```apache
<VirtualHost *:80>
    ServerName fisherfolk.calapancity.gov.ph
    ServerAdmin admin@calapancity.gov.ph
    DocumentRoot /var/www/fmo-fisherfolk/public

    <Directory /var/www/fmo-fisherfolk/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/fmo-error.log
    CustomLog ${APACHE_LOG_DIR}/fmo-access.log combined
</VirtualHost>
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name fisherfolk.calapancity.gov.ph;
    root /var/www/fmo-fisherfolk/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🔒 SSL/HTTPS Setup (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache -y

# For Apache
sudo certbot --apache -d fisherfolk.calapancity.gov.ph

# For Nginx
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d fisherfolk.calapancity.gov.ph

# Auto-renewal (already configured)
sudo certbot renew --dry-run
```

---

## 📊 Performance Optimization

### MySQL Tuning:

```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

Add/modify:
```ini
[mysqld]
innodb_buffer_pool_size = 256M
innodb_log_file_size = 64M
max_connections = 150
query_cache_type = 1
query_cache_size = 16M
```

```bash
sudo systemctl restart mysql
```

### PHP Optimization:

```bash
sudo nano /etc/php/8.3/fpm/php.ini
```

Update:
```ini
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 10M
post_max_size = 10M
```

```bash
sudo systemctl restart php8.3-fpm
```

---

## 🧪 Testing MySQL Connection

Create a test script:

```php
<?php
// test_mysql.php
$host = '127.0.0.1';
$dbname = 'fmo_fisherfolk_management_system';
$username = 'fmo_user';
$password = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "✅ MySQL connection successful!\n";
    echo "Database: $dbname\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Users in database: " . $result['count'] . "\n";
    
} catch(PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
}
?>
```

Run:
```bash
php test_mysql.php
```

---

## 🚨 Troubleshooting

### Connection Refused:
```bash
# Check MySQL is running
sudo systemctl status mysql

# Check MySQL is listening
sudo netstat -tlnp | grep mysql

# Check firewall
sudo ufw status
sudo ufw allow 3306/tcp  # Only if remote access needed
```

### Access Denied:
```bash
# Reset user password
sudo mysql -u root -p
ALTER USER 'fmo_user'@'localhost' IDENTIFIED BY 'new_password';
FLUSH PRIVILEGES;
```

### Migrations Fail:
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear

# Check database connection
php artisan tinker
DB::connection()->getPdo();
```

---

## 📋 Production Checklist

- [ ] MySQL installed and secured
- [ ] Database created with proper charset
- [ ] User created with appropriate privileges
- [ ] `.env` configured with MySQL credentials
- [ ] Application key generated
- [ ] Migrations run successfully
- [ ] Initial users seeded
- [ ] Storage symlink created
- [ ] File permissions set correctly
- [ ] Frontend assets built
- [ ] Config cached
- [ ] SSL certificate installed
- [ ] Backup system configured
- [ ] Firewall configured
- [ ] Web server configured
- [ ] DNS configured
- [ ] Tested thoroughly

---

**Security Note:** Never commit `.env` or `.env.production` files to Git! They contain sensitive credentials.
