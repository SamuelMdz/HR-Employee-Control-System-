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
  <meta charset="UTF-8">
  <title>Dashboard — HR-ECS</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="page-wrapper">

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo">HR</div>
      <span>HR-ECS</span>
    </div>
    <nav>
      <a href="dashboard.php" class="active">Dashboard</a>
      <?php if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager"): ?>
        <a href="employees.php">Employees</a>
      <?php endif; ?>
      <a href="leave.php">Leave Requests</a>
    </nav>
    <div class="sidebar-footer">
      <a href="logout.php">Logout</a>
    </div>
  </aside>

  <!-- Main content -->
  <div class="main-content">

    <!-- Top bar -->
    <div class="topbar">
      <h1>Dashboard</h1>
      <div class="topbar-user">
        <div class="avatar">
          <?php echo strtoupper(substr($_SESSION["username"], 0, 1)); ?>
        </div>
        <span><?php echo $_SESSION["username"]; ?></span>
      </div>
    </div>

    <!-- Page content -->
    <div class="content">

      <div class="page-header">
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
      </div>

      <div class="card">
        <p>Role: <strong><?php echo ucfirst($_SESSION["role"]); ?></strong></p>
        <br>

        <?php if ($_SESSION["role"] == "admin"): ?>
          <a href="employees.php" class="btn btn-primary">Manage Employees</a>

        <?php elseif ($_SESSION["role"] == "manager"): ?>
          <a href="employees.php" class="btn btn-primary">View Employees</a>

        <?php else: ?>
          <a href="leave.php" class="btn btn-primary">My Leave Requests</a>

        <?php endif; ?>
      </div>

    </div><!-- /content -->
  </div><!-- /main-content -->
</div><!-- /page-wrapper -->

</body>
</html>
