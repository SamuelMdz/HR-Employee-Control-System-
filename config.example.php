<?php

$host     = "localhost";
$username = "root";
$password = "YOUR_PASSWORD_HERE";
$database = "hr_test";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>