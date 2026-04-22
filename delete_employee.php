<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the emplyee ID from the URL
$id = $_GET['id'];

// Delete the employee from the database
$sql = "DELETE FROM employees WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    header('Location: employees.php');
    exit;
} else {
    echo "Something went wrong. MySQL error: " . mysqli_error($conn);
}