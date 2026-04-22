<?php
require_once "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error   = "";
$success = "";

// Get the employee ID from the URL
$id = $_GET["id"];

// Fetch the employee's current data
$sql    = "SELECT * FROM employees WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$employee = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name      = $_POST["name"];
    $job_title = $_POST["job_title"];
    $status    = $_POST["status"];

    if (empty($name) || empty($job_title) || empty($status)) {
        $error = "All fields are required.";
    } else {
        $sql    = "UPDATE employees 
                   SET name = '$name', job_title = '$job_title', status = '$status'
                   WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $success = "Employee updated successfully!";
        } else {
            $error = "Something went wrong. MySQL error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Employee — HR-ECS</title>
</head>
<body>

  <h1>Edit Employee</h1>
  <a href="employees.php">Back to Employees</a>
  <br><br>

  <?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>

  <?php if ($success): ?>
    <p style="color: green;"><?php echo $success; ?></p>
  <?php endif; ?>

  <form method="POST" action="edit_employee.php?id=<?php echo $id; ?>">

    <label>Name</label><br>
    <input type="text" name="name" 
           value="<?php echo $employee["name"]; ?>"><br><br>

    <label>Job Title</label><br>
    <input type="text" name="job_title" 
           value="<?php echo $employee["job_title"]; ?>"><br><br>

    <label>Status</label><br>
    <select name="status">
      <option value="active" 
        <?php if ($employee["status"] == "active") echo "selected"; ?>>
        Active
      </option>
      <option value="inactive" 
        <?php if ($employee["status"] == "inactive") echo "selected"; ?>>
        Inactive
      </option>
    </select><br><br>

    <button type="submit">Save Changes</button>

  </form>

</body>
</html>