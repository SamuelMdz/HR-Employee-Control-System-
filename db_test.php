<?php require_once "config.php"; ?>

<!DOCTYPE html>
<html>
<body>

  <table border="1">
    <tr>
      <th>Name</th>
      <th>Job Title</th>
      <th>Status</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM employees");
    while ($row = mysqli_fetch_assoc($result)):
    ?>
      <tr>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["job_title"]; ?></td>
        <td><?php echo $row["status"]; ?></td>
      </tr>
    <?php endwhile; ?>

  </table>

</body>
</html>