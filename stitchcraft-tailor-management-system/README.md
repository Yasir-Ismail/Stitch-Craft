# StitchCraft Tailors - Management System

StitchCraft Tailors is a premium Tailor / Boutique Order Management System designed specifically for modern tailoring shops to manage customer measurements, orders, and delivery schedules efficiently.

**Tagline**: *Smart Order Tracking for Modern Tailors*

## Features

- **Admin Authentication**: Secure login using PHP session and password hashing.
- **Dashboard**: Quick overview of business statistics including total customers, total orders, pending/in-stitching/ready orders, and today's deliveries.
- **Customer Management**: Add, view, edit, and manage all your customers.
- **Dynamic Measurement Storage**: Core module to save specific measurements for both men and women. Linked directly to customer profiles.
- **Order Creation & Tracking**: Create new clothes orders linked to specific customers. Define dress type, fabric details, pricing, delivery dates. 
- **Order Status Tracking**: Update tracking states (Pending -> In Stitching -> Ready -> Delivered).
- **Mobile-friendly UI**: Built with Bootstrap, utilizing a simple beige and brown "boutique" aesthetic.

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5 (CDN)
- **Backend**: Core PHP (Procedural/OOP mix)
- **Database**: MySQL (Prepared Statements for Security)
- **Environment**: XAMPP / WAMP

## Setup Instructions

1. Install XAMPP or WAMP to run a local web server with PHP and MySQL.
2. Clone or copy the `stitchcraft-tailor-management-system` folder into your `htdocs` (XAMPP) or `www` (WAMP) folder.
3. Open PHPMyAdmin (usually `http://localhost/phpmyadmin`) and run the SQL script found in `database/schema.sql` to create the `stitchcraft` database and the necessary tables.
4. **Database Config**: If your local MySQL setup has a password for the `root` user, edit `/config/db.php` and update the `$pass` variable.
5. In your browser, navigate to the application:
   ```
   http://localhost/stitchcraft-tailor-management-system/public/login.php
   ```
6. **Login Credentials**:
   - **Username**: admin
   - **Password**: admin123

## Security Implemented
- **Password Hashing**: `password_hash()` and `password_verify()` uses robust bcrypt hashing.
- **Prepared Statements**: Used in all DB interactions to prevent SQL injection.
- **Session Protection**: All inner pages require a valid session to bypass unauthorized access.
