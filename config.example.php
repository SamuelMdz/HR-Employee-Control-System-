<?php
// ============================================================
// config.php — Database connection and API settings
// Copy this file, rename it to config.php, and fill in your
// own values. Never commit config.php to GitHub.
// ============================================================

$host     = "localhost";
$username = "root";
$password = "YOUR_MYSQL_PASSWORD_HERE";
$database = "hr_test";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Brevo API settings
define("BREVO_API_KEY", "YOUR_BREVO_API_KEY_HERE");
define("MAIL_FROM",     "YOUR_VERIFIED_BREVO_EMAIL_HERE");
define("MAIL_NAME",     "CoreAxisHR");
?>
