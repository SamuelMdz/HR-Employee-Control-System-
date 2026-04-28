<?php
require_once "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error   = "";
$success = "";

// Handle leave request submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_SESSION["employee_id"];
    $type        = $_POST["type"];
    $start_date  = $_POST["start_date"];
    $end_date    = $_POST["end_date"];
    $reason      = $_POST["reason"];

    if (empty($type) || empty($start_date) || empty($end_date) || empty($reason)) {
        $error = "All fields are required.";
    } else {
        $sql    = "INSERT INTO leave_requests (employee_id, type, start_date, end_date, reason)
                   VALUES ('$employee_id', '$type', '$start_date', '$end_date', '$reason')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $success = "Leave request submitted successfully.";
        } else {
            $error = "Error submitting leave request: " . mysqli_error($conn);
        }
    }
}

// Fetch leave requests based on role
if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager") {
    $sql = "SELECT lr.*, e.name AS employee_name
            FROM leave_requests lr
            JOIN employees e ON lr.employee_id = e.id
            ORDER BY lr.created_at DESC";
    $result = mysqli_query($conn, $sql);
} else {
    $employee_id = $_SESSION["employee_id"];
    $sql = "SELECT lr.*, e.name AS employee_name
            FROM leave_requests lr
            JOIN employees e ON lr.employee_id = e.id
            WHERE lr.employee_id = '$employee_id'
            ORDER BY lr.created_at DESC";
    $result = mysqli_query($conn, $sql);
}

$leave_requests = [];
while ($row = mysqli_fetch_assoc($result)) {
    $leave_requests[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Leave Requests — CoreAxisHR</title>
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
        <a href="employees.php">Employees</a>
      <?php endif; ?>
      <a href="leave.php" class="active">Leave Requests</a>
    </nav>
    <div class="sidebar-footer">
      <a href="logout.php">Logout</a>
    </div>
  </aside>

  <!-- Main content -->
  <div class="main-content">

    <!-- Top bar -->
    <div class="topbar">
      <h1>Leave Requests</h1>
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
        <h2>
          <?php if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager"): ?>
            All Leave Requests
          <?php else: ?>
            My Leave Requests
          <?php endif; ?>
        </h2>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif; ?>

      <!-- Submit Leave Request Form -->
      <div class="card">
        <h3 style="margin-bottom: 16px; color: #1A2E4A;">Submit New Leave Request</h3>
        <form method="POST" action="leave.php">

          <div class="form-group">
            <label>Leave Type</label>
            <select name="type">
              <option value="">Select Type</option>
              <option value="Annual">Annual</option>
              <option value="Sick">Sick</option>
              <option value="Unpaid">Unpaid</option>
              <option value="Maternity">Maternity</option>
              <option value="Paternity">Paternity</option>
              <option value="Vacation">Vacation</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="form-group">
            <label>Start Date</label>
            <input type="date" name="start_date">
          </div>

          <div class="form-group">
            <label>End Date</label>
            <input type="date" name="end_date">
          </div>

          <div class="form-group">
            <label>Reason</label>
            <textarea name="reason" rows="3"
                      placeholder="Briefly explain your leave request..."></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Submit Request</button>

        </form>
      </div>

      <!-- Leave Requests Table -->
      <div class="card" style="padding: 0;">
        <table>
          <thead>
            <tr>
              <?php if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager"): ?>
                <th>Employee</th>
              <?php endif; ?>
              <th>Type</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Reason</th>
              <th>Status</th>
              <th>Submitted At</th>
              <?php if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager"): ?>
                <th>Actions</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($leave_requests)): ?>
              <tr>
                <td colspan="<?php echo ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager") ? 8 : 6; ?>"
                    style="text-align: center; padding: 24px; color: #5A6A7A;">
                  No leave requests found.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($leave_requests as $request): ?>
                <tr>
                  <?php if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager"): ?>
                    <td><?php echo $request["employee_name"]; ?></td>
                  <?php endif; ?>
                  <td><?php echo $request["type"]; ?></td>
                  <td><?php echo $request["start_date"]; ?></td>
                  <td><?php echo $request["end_date"]; ?></td>
                  <td><?php echo $request["reason"]; ?></td>
                  <td>
                    <span class="badge badge-<?php echo strtolower($request["status"]); ?>">
                      <?php echo ucfirst($request["status"]); ?>
                    </span>
                  </td>
                  <td><?php echo $request["created_at"]; ?></td>
                  <?php if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "manager"): ?>
                    <td>
                      <?php if ($request["status"] == "pending"): ?>
                        <a href="leave_action.php?id=<?php echo $request["id"]; ?>&action=approved"
                           class="btn btn-primary"
                           style="background-color: #3CB371;"
                           onclick="return confirmApprove()">
                          Approve
                        </a>
                        <a href="leave_action.php?id=<?php echo $request["id"]; ?>&action=rejected"
                           class="btn btn-danger"
                           onclick="return confirmReject()">
                          Reject
                        </a>
                      <?php else: ?>
                        —
                      <?php endif; ?>
                    </td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div><!-- /content -->
  </div><!-- /main-content -->
</div><!-- /page-wrapper -->

<script src="js/app.js"></script>
</body>
</html>
