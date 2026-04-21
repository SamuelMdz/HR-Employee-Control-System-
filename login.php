<?php
require_once "config.php";
session_start();

//If already logged in, skip the login page
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];


        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login — HR-ECS</title>
</head>
<body>

  <h1>HR-ECS Login</h1>

  <?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="POST" action="login.php">

    <label>Username</label><br>
    <input type="text" name="username"><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Sign In</button>

  </form>

</body>
</html>