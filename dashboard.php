<?php
require_once "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard — HR-ECS</title>
</head>
<body>

  <h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
  <p>Role: <?php echo $_SESSION["role"]; ?></p>

  <?php if ($_SESSION["role"] == "admin"): ?>

    <h2>Admin Panel</h2>
    <ul>
      <li><a href="employees.php">Manage Employees</a></li>
      <li><a href="leave.php">Manage Leave Requests</a></li>
    </ul>

  <?php elseif ($_SESSION["role"] == "manager"): ?>

    <h2>Manager Panel</h2>
    <ul>
      <li><a href="employees.php">View Employees</a></li>
      <li><a href="leave.php">Review Leave Requests</a></li>
    </ul>

  <?php else: ?>

    <h2>Employee Panel</h2>
    <ul>
      <li><a href="leave.php">My Leave Requests</a></li>
    </ul>

  <?php endif; ?>

  <br>
  <a href="logout.php">Logout</a>

</body>
</html>