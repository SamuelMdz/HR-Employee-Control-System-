<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$error   = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $job_title = $_POST["job_title"];
    $status = $_POST["status"];

    if (empty($name) || empty($job_title) || empty($status)) {
        $error = "All fields are required.";
    } else {
        $sql = "INSERT INTO employees (name, job_title, status)
        VALUES ('$name','$job_title', '$status')";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $success = "Employee added successfully.";
    } else {
        $error = "Something went wrong. Please try again.";
    } 
}
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Employee — HR-ECS</title>
</head>
<body>

  <h1>Add New Employee</h1>
  <a href="employees.php">Back to Employees</a>
  <br><br>

  <?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>

  <?php if ($success): ?>
    <p style="color: green;"><?php echo $success; ?></p>
  <?php endif; ?>

  <form method="POST" action="add_employee.php">

    <label>Name</label><br>
    <input type="text" name="name"><br><br>

    <label>Job Title</label><br>
    <input type="text" name="job_title"><br><br>

    <label>Status</label><br>
    <select name="status">
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select><br><br>

    <button type="submit">Add Employee</button>

  </form>

</body>
</html>