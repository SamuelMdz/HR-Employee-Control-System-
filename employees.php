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
  <title>Employees — HR-ECS</title>
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
      <h1>Employees</h1>
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
        <h2>Employee Directory</h2>
        <?php if ($_SESSION["role"] == "admin"): ?>
          <a href="add_employee.php" class="btn btn-primary">+ Add Employee</a>
        <?php endif; ?>
      </div>

      <div class="card" style="padding: 0;">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Job Title</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM employees");
            while ($row = mysqli_fetch_assoc($result)):
            ?>
              <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["job_title"]; ?></td>
                <td>
                  <span class="badge badge-<?php echo $row["status"]; ?>">
                    <?php echo ucfirst($row["status"]); ?>
                  </span>
                </td>
                <td>
                  <a href="edit_employee.php?id=<?php echo $row["id"]; ?>"
                     class="btn btn-secondary">Edit</a>
                  <?php if ($_SESSION["role"] == "admin"): ?>
                    <a href="delete_employee.php?id=<?php echo $row["id"]; ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Are you sure you want to delete this employee?')">
                      Delete
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    </div><!-- /content -->
  </div><!-- /main-content -->
</div><!-- /page-wrapper -->

</body>
</html>
