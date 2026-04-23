# CoreAxisHR
# Oswaldo Cardona and Samuel Mendoza
### HR Employee Control System — Phase 2 (In Progress)

---

## Project Overview
CoreAxisHR is a web-based Human Resources management system built as a full stack web application. It allows organizations to manage employees, track attendance, handle leave requests, and more — all through a role-based secure interface.

---

## Current Status
This project is currently in **Phase 2 — Development**. The following features are working:

- Login and logout with session management
- Role-based access control (Admin, Manager, Employee)
- Employee directory with full CRUD (Create, Read, Update, Delete)
- Consistent branding and styling across all pages
- Responsive sidebar navigation

---

## Tech Stack
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Server:** Apache (XAMPP)
- **Version Control:** Git / GitHub

---

## Pages Built
| Page | File | Description |
|---|---|---|
| Login | login.php | Authenticates users and starts session |
| Dashboard | dashboard.php | Role-filtered home page |
| Employee Directory | employees.php | Lists all employees with search |
| Add Employee | add_employee.php | Form to create a new employee |
| Edit Employee | edit_employee.php | Form to update employee details |
| Delete Employee | delete_employee.php | Removes an employee record |
| Logout | logout.php | Destroys session and redirects to login |

---

## User Roles
| Role | Access |
|---|---|
| Admin | Full access — manage employees, view all leave requests, system settings |
| Manager | View employees in their department, review leave requests |
| Employee | View own profile, submit and view own leave requests |

---

## Database
- **Database name:** hr_test
- **Tables:** employees, users

---

## Setup Instructions
1. Install XAMPP and start Apache and MySQL
2. Open phpMyAdmin at http://localhost/phpmyadmin
3. Create a database called `hr_test`
4. Import `database/schema.sql` to create the tables
5. Import `database/sample_data.sql` to load test data
6. Clone this repo into your XAMPP htdocs folder:
```
C:\xampp\htdocs\HR-Employee-Control-System-
```
7. Create a `config.php` file in the project root:
```php
<?php
$host     = "localhost";
$username = "root";
$password = "your_mysql_password";
$database = "hr_test";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```
8. Open your browser and go to:
```
http://localhost/HR-Employee-Control-System-/login.php
```

---

## Test Login Credentials
| Username | Password | Role |
|---|---|---|
| alice | admin123 | Admin |
| bob | manager123 | Manager |
| carol | employee123 | Employee |

---

## Project Structure
```
HR-Employee-Control-System-/
├── css/
│   └── style.css          — Global stylesheet (CoreAxisHR branding)
├── images/                — Logo and image assets
├── add_employee.php       — Add new employee
├── config.php             — Database connection (not tracked by Git)
├── dashboard.php          — Main dashboard
├── delete_employee.php    — Delete employee
├── edit_employee.php      — Edit employee details
├── employees.php          — Employee directory
├── login.php              — Login page
├── logout.php             — Logout
├── db_test.php            — Database connection test (development only)
└── README.md              — This file
```

---

## Upcoming Features (Remaining Phase 2 Work)
- Leave requests — submit, approve, and reject
- JavaScript interactivity
- Brevo API email notifications
- Performance reviews
- Payroll summary

---

## Git Branches
| Branch | Description |
|---|---|
| main | Stable, reviewed code only |
| feature/login-dashboard | Login, logout, and dashboard pages |
| feature/employee-crud | Employee directory and CRUD operations |
| feature/styling-branding | CoreAxisHR branding and CSS styling |

---

## Notes
- `config.php` is excluded from Git via `.gitignore` — each developer must create their own local copy
- Passwords are currently stored as plain text for development purposes — will be updated to use `password_hash()` before final submission
- Database name will be updated from `hr_test` to `coreaxishr` before Phase 3
