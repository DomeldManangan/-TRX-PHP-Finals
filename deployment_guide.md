# Library System Deployment Guide

This guide will help you deploy your Library Management System to various hosting providers.

## Quick Start (000webhost - Free)

### Step 1: Sign Up
1. Go to https://000webhost.com
2. Click "Create Website"
3. Choose a subdomain (e.g., `mylibrary.000webhostapp.com`)
4. Complete registration

### Step 2: Upload Files
1. Go to your hosting control panel
2. Click "File Manager"
3. Navigate to `public_html` folder
4. Upload your entire `Library` folder
5. Extract if needed

### Step 3: Create Database
1. In control panel, click "Databases"
2. Create a new MySQL database
3. Note down:
   - Database name (e.g., `1234567_library`)
   - Username (e.g., `1234567_admin`)
   - Password
   - Hostname (usually `localhost`)

### Step 4: Update Database Connection
1. Edit `config/db.php`
2. Update with your database credentials:
   ```php
   $host = 'localhost';
   $db   = 'your_database_name';
   $user = 'your_username';
   $pass = 'your_password';
   ```

### Step 5: Import Database
1. Go to phpMyAdmin in your control panel
2. Select your database
3. Click "Import"
4. Upload `sql_setup.sql`
5. Click "Go"

### Step 6: Create Admin User
1. Visit: `http://your-domain.com/create_admin.php`
2. You should see: "Admin user created. Username: admin Password: admin123"
3. **Delete** `create_admin.php` file

### Step 7: Test
1. Go to `http://your-domain.com/public/login.php`
2. Login with: `admin` / `admin123`
3. Test all features

---

## Paid Hosting (HostGator, Bluehost, etc.)

### Step 1: Purchase Hosting
1. Choose a hosting plan with PHP and MySQL
2. Complete purchase and setup

### Step 2: Access Control Panel
1. Login to your hosting control panel (cPanel)
2. Find "File Manager" or use FTP

### Step 3: Upload Files
**Option A: File Manager**
1. Open File Manager
2. Navigate to `public_html`
3. Upload and extract your `Library` folder

**Option B: FTP**
1. Use FileZilla or similar FTP client
2. Connect to your server
3. Upload `Library` folder to `public_html`

### Step 4: Create Database
1. In cPanel, find "MySQL Databases"
2. Create new database
3. Create database user
4. Assign user to database with all privileges

### Step 5: Update Database Connection
Edit `config/db.php` with your credentials

### Step 6: Import Database
1. Open phpMyAdmin
2. Select your database
3. Import `sql_setup.sql`

### Step 7: Create Admin User
1. Visit: `http://your-domain.com/create_admin.php`
2. Delete the file after use

---

## VPS Hosting (DigitalOcean, Linode)

### Step 1: Set Up Server
1. Create a new VPS
2. Install LAMP stack (Linux, Apache, MySQL, PHP)
3. Configure domain DNS

### Step 2: Upload Files
```bash
# Via SCP
scp -r Library/ user@your-server:/var/www/html/

# Or via Git
git clone your-repository
```

### Step 3: Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/html/Library
sudo chmod -R 755 /var/www/html/Library
```

### Step 4: Create Database
```bash
mysql -u root -p
CREATE DATABASE library_db;
CREATE USER 'library_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON library_db.* TO 'library_user'@'localhost';
FLUSH PRIVILEGES;
```

### Step 5: Import Database
```bash
mysql -u library_user -p library_db < sql_setup.sql
```

### Step 6: Update Database Connection
Edit `config/db.php` with your credentials

### Step 7: Create Admin User
Visit: `http://your-domain.com/create_admin.php`

---

## Troubleshooting

### Common Issues

**1. Database Connection Error**
- Check database credentials in `config/db.php`
- Verify database exists and user has permissions
- Check if MySQL service is running

**2. File Not Found (404)**
- Verify file paths are correct
- Check if files are in the right directory
- Ensure Apache/Nginx is configured properly

**3. Permission Denied**
- Set correct file permissions (644 for files, 755 for directories)
- Check file ownership

**4. Session Issues**
- Ensure `session_start()` is called before any output
- Check if sessions are enabled in PHP

**5. Custom Book ID Not Working**
- Verify the `book_id` column exists in the database
- Check if the generation logic is working correctly

### Error Logs
- Check hosting control panel for error logs
- Enable PHP error reporting for debugging:
  ```php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```

### Security Checklist
- [ ] Delete `create_admin.php` after use
- [ ] Change default admin password
- [ ] Enable HTTPS if available
- [ ] Set proper file permissions
- [ ] Regular database backups
- [ ] Keep PHP and server software updated

---

## Post-Deployment

### 1. Test All Features
- [ ] Admin login
- [ ] Add/edit books
- [ ] Student registration
- [ ] Book borrowing (max 2)
- [ ] Book returning
- [ ] Fine calculation
- [ ] Book status changes

### 2. Add Content
- [ ] Add at least 50 books (already included in SQL)
- [ ] Register student accounts
- [ ] Test borrowing scenarios

### 3. Monitor
- [ ] Check error logs regularly
- [ ] Monitor database performance
- [ ] Backup data regularly

---

## Support

If you encounter issues:
1. Check this troubleshooting guide
2. Review hosting provider documentation
3. Check PHP and MySQL error logs
4. Verify all files are uploaded correctly
5. Test database connection separately

Your Library System should now be fully functional online! 