<?php
require_once "config.php";
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql    = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $user   = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION["user_id"]     = $user["id"];
        $_SESSION["username"]    = $user["username"];
        $_SESSION["role"]        = $user["role"];
        $_SESSION["employee_id"] = $user["employee_id"];
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
  <meta charset="UTF-8">
  <title>Login — CoreAxisHR</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #1A2E4A 0%, #2E4A6E 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .login-card {
      background: white;
      border-radius: 16px;
      padding: 40px 32px;
      width: 100%;
      max-width: 380px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .login-logo {
      width: 60px;
      height: 60px;
      background: #2E7DF7;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
      font-size: 18px;
      font-weight: 700;
      color: white;
    }

    .login-title {
      text-align: center;
      font-size: 22px;
      font-weight: 700;
      color: #1A2E4A;
      margin-bottom: 4px;
    }

    .login-subtitle {
      text-align: center;
      font-size: 13px;
      color: #5A6A7A;
      margin-bottom: 28px;
    }

    .login-btn {
      width: 100%;
      padding: 10px;
      background: #2E7DF7;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 8px;
      transition: background 0.2s;
    }

    .login-btn:hover {
      background: #1A6AE0;
    }


      background: #EAF1FE;
      border-radius: 8px;
      padding: 12px;
      font-size: 12px;
      color: #5A6A7A;
      margin-top: 20px;
      line-height: 1.8;
    }


      color: #1A2E4A;
    }
  </style>
</head>
<body>

  <div class="login-card">

    <div class="login-logo">CA</div>
    <h1 class="login-title">CoreAxisHR</h1>
    <p class="login-subtitle">Your Workforce, Organized.</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">

      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username"
               placeholder="Enter your username" autofocus>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password"
               placeholder="Enter your password">
      </div>

      <button type="submit" class="login-btn">Sign In</button>

    </form>


      <strong>Demo accounts</strong><br>
      Admin: alice / admin123<br>
      Manager: bob / manager123<br>
      Employee: carol / employee123
    </div>

  </div>

</body>
</html>
