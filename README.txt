CoreAxisHR — HR Employee Control System
Phase 2 Submission

================================================================
PROJECT SETUP
================================================================

1. Install XAMPP and start Apache and MySQL
2. Open phpMyAdmin at http://localhost/phpmyadmin
3. Run database/schema.sql to create the tables
4. Run database/sample_data.sql to load test data
5. Copy config.example.php and rename it to config.php
6. Fill in your MySQL password and Brevo API key in config.php
7. Place the website folder in C:\xampp\htdocs\
8. Open http://localhost/HR-Employee-Control-System-/login.php

================================================================
TEST LOGIN CREDENTIALS
================================================================

Admin:    username: alice    password: admin123
Manager:  username: bob      password: manager123
Employee: username: carol    password: employee123

================================================================
FEATURES IMPLEMENTED
================================================================

- Login and logout with session management
- Role-based access control (Admin, Manager, Employee)
- Employee directory with full CRUD
- Leave requests (submit, approve, reject)
- Email notifications via Brevo API
- JavaScript live search on employee directory
- JavaScript confirm dialogs on all destructive actions
- CoreAxisHR branding applied consistently across all pages

================================================================
DATABASE
================================================================

Database name: hr_test
Tables: employees, users, leave_requests

================================================================
NOTES
================================================================

- config.php is excluded from submission as it contains
  sensitive credentials. Use config.example.php as a template.
- Passwords are stored as plain text for development purposes.
- Email notifications are sent to the configured MAIL_FROM
  address in config.php.
