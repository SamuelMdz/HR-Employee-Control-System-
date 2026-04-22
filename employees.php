<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION{"user_id"})) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employees - HR-ECS</title>
</head>

<body>
    <h1>Employees</h1>
    <a href="dashboard.php">Back to Dashboard</a>
    <br><br>

    <a href="add_employee.php">+ Add New Employee</a>
    <br><br>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Job Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM employees");
        while ($row = mysqli_fetch_assoc($result)) :
        ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["name"] ?></td>
                <td><?php echo $row["job_title"] ?></td>
                <td><?php echo $row["status"] ?></td>
                <td>
                    <a href="edit_employee.php?id=<?php echo $row["id"]; ?>">Edit</a>
                    &nbsp;
                    <a href="delete_employee.php?id=<?php echo $row["id"]; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>
    
</body>
</html>