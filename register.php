<?php
require 'db.php';

$msg = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
        exit;
    } else {
        $msg = "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
    <h2>Register</h2>
    <?php if ($msg) echo "<p style='color:red;'>$msg</p>"; ?>
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
        </select>
        <input type="submit" value="Register">
    </form>
    <p><a href="login.php">Already have an account? Log in</a></p>
</div>
</body>
</html>
