<?php
session_start();
require 'db.php';

$msg = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($res);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $msg = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <img src="images/logo_esprit_training.png" class="logo" alt="Logo">
    <h1 class="slogan">
    <span class="black">Train. Track.</span>
    <span class="red"> Transform.</span>
</h1>
</div>

<div class="container">
    <h2>Login</h2>
    <?php if ($msg) echo "<p style='color:red;'>$msg</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <p><a href="register.php">Don't have an account? Register</a></p>
</div>
</body>
</html>
