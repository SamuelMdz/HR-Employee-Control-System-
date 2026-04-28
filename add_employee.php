<?php
require_once "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error   = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name      = $_POST["name"];
    $job_title = $_POST["job_title"];
    $status    = $_POST["status"];

    if (empty($name) || empty($job_title) || empty($status)) {
        $error = "All fields are required.";
    } else {
        $sql    = "INSERT INTO employees (name, job_title, status)
                   VALUES ('$name', '$job_title', '$status')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $success = "Employee added successfully!";
        } else {
            $error = "Something went wrong. " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Employee — CoreAxisHR</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="page-wrapper">

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo">CA</div>
      <span>CoreAxisHR</span>
    </div>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <?php if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager"): ?>
        <a href="employees.php" class="active">Employees</a>
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
      <h1>Add Employee</h1>
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
        <h2>Add New Employee</h2>
        <a href="employees.php" class="btn btn-secondary">Back to Employees</a>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif; ?>

      <div class="card">
        <form method="POST" action="add_employee.php" onsubmit="return confirmAdd()">

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Full name">
          </div>

          <div class="form-group">
            <label>Job Title</label>
            <input type="text" name="job_title" placeholder="e.g. HR Manager">
          </div>

          <div class="form-group">
            <label>Status</label>
            <select name="status">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Add Employee</button>

        </form>
      </div>

    </div><!-- /content -->
  </div><!-- /main-content -->
</div><!-- /page-wrapper -->

<script src="js/app.js"></script>
</body>
</html>
