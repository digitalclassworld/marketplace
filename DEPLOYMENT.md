# Digital Class Marketplace - Complete Deployment & Server Setup Guide

This guide covers deployment instructions for **Windows Local Environments**, **Linux Cloud VPS (Ubuntu/Nginx/Apache)**, and **cPanel Shared Hosting**.

---

## 📋 1. Prerequisites & Server Requirements

| Component | Minimum Version | Recommended |
| :--- | :--- | :--- |
| **PHP** | `8.2.0` or higher | `PHP 8.2` or `8.3` |
| **Laravel** | `12.x` | `12.x` |
| **MySQL / MariaDB** | `8.0+` / `10.4+` | `MySQL 8.0` with `utf8mb4` |
| **Composer** | `2.x` | Latest `Composer 2` |
| **Node.js & npm** | `18.x+` / `9.x+` | Only needed to compile Vite assets (pre-compiled files included in `public/build`) |
| **Web Server** | Apache 2.4+ / Nginx 1.18+ | Nginx or Apache with `mod_rewrite` enabled |

### Required PHP Extensions
Ensure the following PHP extensions are enabled in your server's `php.ini`:
- `pdo_mysql` (Database connectivity)
- `mbstring` (Multi-byte string handling)
- `openssl` (Secure token generation and encryption)
- `tokenizer` (Blade compilation)
- `xml` & `dom` (XML processing)
- `ctype` (Character type checking)
- `json` (API & JSON column handling)
- `bcmath` (Precision financial math)
- `curl` (HTTP requests)
- `fileinfo` (Image and avatar upload MIME detection)

---

## ⚡ 2. Quick Setup Checklist (For Any Server)

When cloning or pulling the project onto a new computer or server, execute these commands in sequence:

```bash
# 1. Clone repository
git clone https://github.com/digitalclassworld/marketplace.git
cd marketplace

# 2. Install Composer dependencies
composer install --no-dev --optimize-autoloader

# 3. Create .env file and generate APP_KEY (CRITICAL: prevents 500 Server Error)
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 5. Run Database Migrations & Seeders
php artisan migrate --force --seed

# 6. Ensure public upload directories exist & are writable
mkdir -p public/uploads/avatars

# 7. Clear & cache configuration for maximum production performance
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🟣 3. Hostinger Deployment Guide (hPanel & Cloud / Shared Hosting)

Hostinger is one of the most popular hosting platforms, but running modern Laravel on Hostinger requires specific settings in **hPanel**. Follow these 5 steps to get the platform running with 0 errors:

### Step 1: Switch PHP Version to PHP 8.2 or 8.3 (CRITICAL)
> [!WARNING]
> Hostinger often defaults new websites to **PHP 8.0 or 8.1**. Since this marketplace is built with **Laravel 12**, it strictly requires **PHP 8.2+**. If PHP 8.1 is active, Hostinger will immediately show a `500 Server Error` on load!

1. Log in to **Hostinger hPanel**.
2. Go to **Websites** &rarr; click **Manage** next to your domain.
3. In the left sidebar, go to **Advanced** &rarr; **PHP Configuration**.
4. Select **PHP 8.2** or **PHP 8.3**.
5. Click **Save** and wait 30 seconds for the change to apply.

---

### Step 2: Upload Project Files to `public_html`
You can deploy using either Hostinger Git or File Manager:

**Method A: Hostinger Git Deployment (Recommended):**
1. In hPanel, go to **Advanced** &rarr; **Git**.
2. Enter Repository: `https://github.com/digitalclassworld/marketplace.git`
3. Branch: `main`
4. Install Directory: `/public_html` (or leave blank for root of domain).
5. Click **Create** &rarr; click **Deploy**.

**Method B: File Manager (ZIP Upload):**
1. In hPanel, open **File Manager**.
2. Go to `public_html/`.
3. Upload and extract the project files directly into `public_html/`.

> [!NOTE]
> The repository includes a pre-configured root [`.htaccess`](.htaccess) and fallback [`index.php`](index.php). When deployed into `public_html/`, Hostinger will automatically route all requests directly to the Laravel application in `public/` without requiring custom symlinks!

---

### Step 3: Import Database via Hostinger phpMyAdmin (No SSH Needed)
If you don't have SSH or terminal access on Hostinger, you can import the entire working database in 30 seconds:

1. In hPanel, go to **Databases** &rarr; **Management**.
2. Create a new MySQL Database:
   - Note down the full Database Name (e.g., `u123456789_market`).
   - Note down the full Username (e.g., `u123456789_user`).
   - Set a strong password.
3. Click **Enter phpMyAdmin** next to the new database.
4. Click the **Import** tab at the top.
5. Click **Choose File** &rarr; select the included [`database/marketplace.sql`](database/marketplace.sql) file.
6. Click **Go** at the bottom.
   *All tables, the Super Admin account, verified sellers, courses, services, products, listings, orders, and chats are imported instantly!*

---

### Step 4: Configure `.env` in Hostinger File Manager
1. In Hostinger **File Manager**, locate `.env.example` in `public_html/`.
2. Rename or copy it to `.env`.
3. Open `.env` and fill in your Hostinger database details:
   ```env
   APP_NAME="Digital Class Marketplace"
   APP_ENV=production
   APP_KEY=base64:Zm+Xo18BQAkDobhIjCc4xUB103aOWqO6yK5+eO76PDs=
   APP_DEBUG=false
   APP_URL=https://yourdomain.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=u123456789_market
   DB_USERNAME=u123456789_user
   DB_PASSWORD=YourHostingerPasswordHere
   ```
   *(Note: A valid production `APP_KEY` is already provided above so the site starts immediately even if you don't have SSH access.)*

---

### Step 5: If You Have Hostinger SSH Access (Optional Optimizations)
If your Hostinger plan includes SSH:
1. In hPanel, go to **Advanced** &rarr; **SSH Access** &rarr; Enable SSH.
2. Connect via terminal:
   ```bash
   ssh -p 65002 u123456789@your-server-ip
   cd domains/yourdomain.com/public_html
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

### Step 6: Troubleshooting Hostinger 500 Server Error
If your site still displays `500 Server Error` on Hostinger:
1. **Check PHP Version:** Ensure hPanel is set to **PHP 8.2** or **8.3**, NOT 8.0/8.1.
2. **Turn on Debug Mode:** In `public_html/.env`, change `APP_DEBUG=false` to `APP_DEBUG=true` and refresh the page to view the exact error.
3. **Database Prefix:** Remember that Hostinger prefixes your database name and username with your account ID (e.g. `u123456789_`). Check that `DB_DATABASE` and `DB_USERNAME` in `.env` include this prefix!
4. **Permissions:** In Hostinger File Manager, right-click `storage` and `bootstrap/cache` &rarr; click **Permissions** &rarr; set to **775** (Recursive).

---

## 🐳 4. Coolify Deployment Guide (Fixing 500 Server Error on Coolify)

If you are deploying using **Coolify** (as shown on VPS `187.127.141.217:8000` with domain `web.digitalclassworld.in`), follow these exact steps to resolve the `500 | SERVER ERROR`:

### Why 500 Server Error happens on a fresh Coolify deployment:
1. **Missing Environment Variables**: Git does not track `.env`. When Coolify clones the repository, the Docker container starts with an empty `.env` unless you configure the **Environment Variables** in the Coolify dashboard.
2. **Missing APP_KEY**: Without `APP_KEY`, Laravel throws `No application encryption key has been specified`.
3. **Session & Cache Driver**: Laravel 12 defaults to `database` sessions. If the database is not yet connected or migrated, Laravel fails with `500 Server Error` on every request.
4. **Database Host**: Inside a Docker container, `DB_HOST=127.0.0.1` tries to connect to the container itself, NOT your server's MySQL!

---

### Step-by-Step Fix in Coolify Dashboard:

#### Step 1: Add Environment Variables in Coolify
1. In **Coolify**, open your application (**Root Team / marketplace / production / average-alligator...**).
2. On the left sidebar menu, click **Environment Variables**.
3. Paste the following configuration:
   ```env
   APP_NAME="Digital Class Marketplace"
   APP_ENV=production
   APP_KEY=base64:Zm+Xo18BQAkDobhIjCc4xUB103aOWqO6yK5+eO76PDs=
   APP_DEBUG=true
   APP_URL=https://web.digitalclassworld.in

   DB_CONNECTION=mysql
   DB_HOST=172.17.0.1
   DB_PORT=3306
   DB_DATABASE=marketplace
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_password_here

   SESSION_DRIVER=file
   CACHE_STORE=file
   FILESYSTEM_DISK=local
   ```
   > [!IMPORTANT]
   > **Resolving `getaddrinfo for host.docker.internal failed: Name or service not known` on Linux**:
   > * On **Linux VPS**, Docker does **NOT** resolve `host.docker.internal` by default.
   > * Set **`DB_HOST=172.17.0.1`** (the standard Docker bridge IP that connects back to the host machine) or your VPS external IP `187.127.141.217`.
   > * Alternatively, in Coolify under **Configuration** &rarr; **Custom Docker Options**, add `--add-host=host.docker.internal:host-gateway`.
   > * If MySQL is running **inside Coolify as a database resource**: use the Coolify internal service name (e.g. `mysql` or the database internal hostname shown in Coolify).
   > * Ensure MySQL allows connections from Docker: check `/etc/mysql/mysql.conf.d/mysqld.cnf` has `bind-address = 0.0.0.0` (or `bind-address = 172.17.0.1`).

4. Click **Save**.

#### Step 2: Check Runtime Logs
1. In Coolify's left sidebar menu, click **Runtime Logs**.
2. If there are any PHP or Laravel errors, the exact stack trace will be printed here in real-time.

#### Step 3: Run Database Migrations in Coolify Terminal
1. In Coolify's left sidebar menu, click **Terminal**.
2. Select the running container and click **Connect**.
3. Run:
   ```bash
   php artisan migrate --force --seed
   php artisan optimize:clear
   ```

#### Step 4: Click Redeploy
1. Click the purple **Redeploy** button at the top right of Coolify.
2. Once the rolling update completes, open `https://web.digitalclassworld.in` in your browser. The site will load immediately!

---

---

## 🖥️ 4. Deployment Scenario A: Windows Local (XAMPP / Laragon / Standalone)

### Step 1: Clone into Web Directory
Clone into `C:\xampp\htdocs\marketplace` or your working directory:
```bash
git clone https://github.com/digitalclassworld/marketplace.git
cd marketplace
```

### Step 2: Install Dependencies
```powershell
composer install
```

### Step 3: Configure Environment
Copy `.env.example` to `.env`:
```powershell
copy .env.example .env
php artisan key:generate
```

Open `.env` and configure your local MySQL settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marketplace
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Create Database in MySQL
In phpMyAdmin (`http://localhost/phpmyadmin`) or via MySQL CLI:
```sql
CREATE DATABASE IF NOT EXISTS marketplace CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 5: Run Migrations & Seeders
```powershell
php artisan migrate --seed
```

### Step 6: Start the Server
```powershell
php artisan serve
```
Open **`http://127.0.0.1:8000`** in your browser.

---

## 🐧 4. Deployment Scenario B: Linux VPS (Ubuntu / Debian + Nginx / Apache)

### Step 1: Clone Repository
```bash
cd /var/www
sudo git clone https://github.com/digitalclassworld/marketplace.git marketplace
cd /var/www/marketplace
```

### Step 2: Set Permissions
The web server user (`www-data`) **must** have read/write access to storage, cache, and upload directories:
```bash
sudo chown -R www-data:www-data /var/www/marketplace
sudo find /var/www/marketplace -type f -exec chmod 644 {} \;
sudo find /var/www/marketplace -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/marketplace/storage /var/www/marketplace/bootstrap/cache /var/www/marketplace/public/uploads
```

### Step 3: Install PHP Dependencies
```bash
sudo -u www-data composer install --no-dev --optimize-autoloader
```

### Step 4: Environment & App Key
```bash
sudo -u www-data cp .env.example .env
sudo -u www-data php artisan key:generate
```

Edit `/var/www/marketplace/.env`:
```env
APP_NAME="Digital Class Marketplace"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marketplace_prod
DB_USERNAME=marketplace_user
DB_PASSWORD=SecurePasswordHere
```

### Step 5: Migrate & Seed Database
```bash
sudo -u www-data php artisan migrate --force --seed
```

### Step 6: Nginx Virtual Host Configuration
> [!IMPORTANT]
> The Nginx `root` **must** point to `/var/www/marketplace/public`, not `/var/www/marketplace`.

Create `/etc/nginx/sites-available/marketplace.conf`:
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/marketplace/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    # Maximum file upload size for avatars and courses
    client_max_body_size 64M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
Enable the site & restart Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/marketplace.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Step 7: Apache Virtual Host (If using Apache)
Ensure `mod_rewrite` is active:
```bash
sudo a2enmod rewrite
```
In `/etc/apache2/sites-available/marketplace.conf`:
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/marketplace/public

    <Directory /var/www/marketplace/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/marketplace_error.log
    CustomLog ${APACHE_LOG_DIR}/marketplace_access.log combined
</VirtualHost>
```

---

## 🌐 5. Deployment Scenario C: cPanel / Shared Hosting

### Step 1: Upload Files
1. In cPanel, navigate to **File Manager**.
2. It is best practice to place your application files **one level above** `public_html` for maximum security:
   - Application root: `/home/username/marketplace/`
   - Public assets: `/home/username/public_html/` (or symlinked)

**Alternative Standard Method (Single folder inside `public_html`):**
If your primary domain points to `public_html`, change the **Document Root** in cPanel:
- In cPanel, go to **Domains** &rarr; Select your domain.
- Set Document Root to: `public_html/public` or `/marketplace/public`.

### Step 2: Create MySQL Database via cPanel
1. Go to **cPanel &rarr; MySQL Databases**.
2. Create database: `cpaneluser_marketplace`.
3. Create user: `cpaneluser_dbuser` with a strong password.
4. Add user to database with **All Privileges**.

### Step 3: Configure `.env`
Create or edit `.env` inside the project folder:
```env
APP_NAME="Digital Class Marketplace"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cpaneluser_marketplace
DB_USERNAME=cpaneluser_dbuser
DB_PASSWORD=YourPasswordHere
```

### Step 4: Run Artisan Commands via cPanel Terminal
Open **cPanel &rarr; Terminal**:
```bash
cd /home/username/marketplace
php artisan key:generate
php artisan migrate --force --seed
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔍 6. Troubleshooting 500 Server Errors

If any page returns `500 Server Error`, run through this 5-point checklist:

### 1. Missing Application Key (`APP_KEY`)
- **Symptom:** Every route throws 500.
- **Cause:** `.env` was missing or `APP_KEY=` was left blank after cloning.
- **Fix:** Run:
  ```bash
  php artisan key:generate
  ```

### 2. Missing Database or Unmigrated Tables
- **Symptom:** `SQLSTATE[HY000] [1049] Unknown database` or `Table 'marketplace.users' doesn't exist`.
- **Cause:** Database was not created, or migrations were not run.
- **Fix:**
  ```bash
  php artisan migrate --force --seed
  ```

### 3. File Permissions on Storage & Cache
- **Symptom:** `The stream or file ".../storage/logs/laravel.log" could not be opened in append mode: Permission denied`.
- **Cause:** Web server process cannot write to `storage/` or `bootstrap/cache/`.
- **Fix:**
  ```bash
  sudo chown -R www-data:www-data storage bootstrap/cache public/uploads
  sudo chmod -R 775 storage bootstrap/cache public/uploads
  ```

### 4. DocumentRoot Misconfigured
- **Symptom:** Visiting domain lists directory contents, throws 403, or `.htaccess` rewrite loops.
- **Cause:** Web server is pointing to the project root instead of `/public`.
- **Fix:** Point the server Document Root strictly to the `/public` directory.

### 5. Inspect the Exact Error
To see the full error stack trace on the screen:
1. Temporarily edit `.env`:
   ```env
   APP_DEBUG=true
   ```
2. Refresh the browser to see the exact file and line number.
3. Check the log file directly:
   ```bash
   tail -n 50 storage/logs/laravel.log
   ```
4. Remember to set `APP_DEBUG=false` once resolved in production.

---

## 🔑 7. Default System Credentials (Seeded by DatabaseSeeder)

| Role | Email | Password | Access URL |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@gmail.com` | `Admin@123` | `/admin/login` &rarr; `/admin/dashboard` |
| **Seller 1 (Active)** | `shop911@gmail.com` | `Seller@123` | `/seller/login` &rarr; `/seller/dashboard` |
| **Seller 2 (Active)** | `seller23@gmail.com` | `Seller@123` | `/seller/login` &rarr; `/seller/dashboard` |
| **Seller 3 (Institute)** | `vinayak@vcec.in` | `Seller@123` | `/seller/login` &rarr; `/seller/dashboard` |
| **Seller 4 (Agency)** | `hello@designstudiopro.com` | `Seller@123` | `/seller/login` &rarr; `/seller/dashboard` |

