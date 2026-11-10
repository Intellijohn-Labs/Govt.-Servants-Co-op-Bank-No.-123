# Installation & Deployment Guide

This guide covers deployment instructions for **Shared cPanel Hosting**, **VPS / Dedicated Servers**, and **Local Development**.

---

## System Requirements

- **PHP**: 8.2 or higher
- **Extensions**: `pdo_mysql` (or `pdo_sqlite`), `mbstring`, `fileinfo`, `curl`, `openssl`, `gd`
- **Database**: MySQL 8.0+ or MariaDB 10.6+ (PDO with prepared statements)
- **Web Server**: Apache 2.4+ with `mod_rewrite` enabled or Nginx

---

## 1. Shared cPanel Hosting Deployment (Zero Build Step)

The template is specifically architected for shared cPanel hosting with no root access and no Node.js build requirement at deploy time.

### Step 1: Upload Files
1. Zip the project repository and upload it via cPanel **File Manager** or SFTP.
2. If your cPanel account allows setting the Document Root:
   - Point your domain's Document Root to `/public_html/public`.
3. If your cPanel restricts Document Root to `/public_html/`:
   - Extract the entire codebase into `/home/username/coop_bank/`.
   - Move the contents of `/public/` into `/public_html/`.
   - Update `index.php` paths to point to `/home/username/coop_bank/app`.
   - Or keep the structure and use the provided root `.htaccess` which automatically rewrites all incoming traffic to `public/`.

### Step 2: Database Setup
1. In cPanel, navigate to **MySQL Databases**.
2. Create a new database: e.g. `cpaneluser_coopbank`.
3. Create a MySQL user with strong credentials and assign `ALL PRIVILEGES` to the database.
4. Open **phpMyAdmin**, select your new database, click **Import**, and upload `database/schema.sql`.

### Step 3: Environment Configuration (`.env`)
1. In File Manager, create or edit `.env` in the root directory:
   ```ini
   APP_NAME="Services Co-operative Bank"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourbankdomain.com
   CLIENT=kalliaseri-scb

   DB_DRIVER=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=cpaneluser_coopbank
   DB_USERNAME=cpaneluser_dbuser
   DB_PASSWORD=YourStrongPasswordHere
   DB_CHARSET=utf8mb4

   MAIL_DRIVER=smtp
   MAIL_HOST=mail.yourbankdomain.com
   MAIL_PORT=465
   MAIL_USERNAME=noreply@yourbankdomain.com
   MAIL_PASSWORD=MailPassword
   MAIL_ENCRYPTION=ssl
   ```

### Step 4: File Permissions
Ensure the following directories are writable by the web server process:
```bash
chmod -R 755 storage
chmod -R 755 public/uploads
```
Ensure `public/uploads/.htaccess` is in place to forbid execution of any uploaded scripts.

---

## 2. VPS Deployment (Ubuntu / Debian + Nginx / Apache)

### Step 1: Clone & Install Dependencies
```bash
cd /var/www
git clone <repo-url> coopbank
cd coopbank
composer install --no-dev --optimize-autoloader
```

### Step 2: Run Database Migrations & Seeding
```bash
php cli.php migrate
php cli.php seed kalliaseri-scb
```

### Step 3: Nginx Virtual Host Configuration
```nginx
server {
    listen 80;
    server_name yourbankdomain.com;
    root /var/www/coopbank/public;
    index index.php;

    charset utf-8;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Block direct PHP execution inside uploads
    location /uploads/ {
        location ~ \.php$ {
            deny all;
        }
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 3. Local Development Setup

1. Copy `.env.example` to `.env`.
2. To test with portable SQLite (zero database installation required):
   - Set `DB_DRIVER=sqlite` in `.env`.
3. Run migrations and seed data:
   ```bash
   php cli.php migrate
   php cli.php seed kalliaseri-scb
   ```
4. Start local development server:
   ```bash
   php -S 127.0.0.1:8000 -t public public/index.php
   ```
5. Open your browser at: `http://127.0.0.1:8000` (English) or `http://127.0.0.1:8000/ml` (Malayalam).
6. Access Admin Portal at `http://127.0.0.1:8000/admin/login` (`admin` / `Admin@12345`).
