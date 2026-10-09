# Shivam Kumar Gupta — Full Portfolio CMS

Production-ready PHP + MySQL portfolio starter with a complete admin CMS.

## Included
- Premium responsive animated portfolio frontend
- Dynamic projects from MySQL
- Project CRUD + image upload + featured/order/live/GitHub fields
- Full blog listing and single post pages
- Blog CRUD with draft/published workflow
- Categories CRUD
- Rich-text blog editor (CKEditor CDN)
- Featured blog image upload
- SEO title + meta description per post
- Dynamic skills CRUD
- Site settings: name, tagline, contact, social links, about, SEO
- CV upload
- Contact form with AJAX submission + MySQL inbox + server-side mail() notification
- Spam honeypot + CSRF protection + prepared SQL statements
- Admin dashboard + unread message count
- Admin password change
- Upload type/size validation
- Basic security headers and config/database blocking via .htaccess

## Requirements
- PHP 8.1+
- MySQL 5.7+/MariaDB 10.4+
- Apache with PHP (XAMPP, Hostinger, cPanel etc.)
- `fileinfo` PHP extension for secure MIME detection

## Install
1. Create a MySQL database or import `database.sql` (the SQL creates `shivam_portfolio`).
2. Edit `config.php`:
   - DB_HOST
   - DB_NAME
   - DB_USER
   - DB_PASS
   - SITE_URL
3. Upload the complete folder to your web root.
4. Make sure `uploads/`, `uploads/projects/`, `uploads/blog/`, and `uploads/cv/` are writable by PHP.
5. Open `/admin/login.php`.

## First admin login
Email: `guptashiavmkumar884@gmail.com`
Password: `password`

Immediately change it from **Admin → Change Password**.

## Admin URLs
- `/admin/` dashboard
- `/admin/projects.php` projects
- `/admin/posts.php` blog posts
- `/admin/categories.php` categories
- `/admin/skills.php` skills
- `/admin/messages.php` contact inbox
- `/admin/settings.php` website + SEO + SMTP settings
- `/admin/password.php` password

## Contact email
The AJAX endpoint is `api/contact.php`. It validates input, stores the message, then attempts a server-side `mail()` notification. On Hostinger, if PHP `mail()` is disabled/restricted, use the hosting mailbox/SMTP setup and replace the mail transport with SMTP credentials. The settings page already stores SMTP fields for that configuration.

## Important production settings
- Change DB credentials.
- Change admin password.
- Change `SITE_URL` to your real HTTPS domain.
- Enable HTTPS.
- Set upload directories to writable but never executable if your host supports it.
- Use a real mailbox for `site_email`.
- Back up the MySQL database regularly.
# portfolio
