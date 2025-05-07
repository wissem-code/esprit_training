<?php
session_start();
require 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($firstname) || !ctype_alpha($firstname)) {
        $errors[] = "First name is required and must be letters only.";
    }
    if (empty($lastname) || !ctype_alpha($lastname)) {
        $errors[] = "Last name is required and must be letters only.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if (empty($password) || strlen($password) < 4) {
        $errors[] = "Password must be at least 4 characters.";
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $fullName = $firstname . ' ' . $lastname;

        $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
        mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $hashed);
        mysqli_stmt_execute($stmt);
        echo "<p>Registration successful. <a href='login.php'>Login</a></p>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>Register</title>
</head>
<body>
<h2>Register</h2>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= $e ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="">
    First Name: <input type="text" name="firstname"><br><br>
    Last Name: <input type="text" name="lastname"><br><br>
    Email: <input type="email" name="email"><br><br>
    Password: <input type="password" name="password"><br><br>
    <input type="submit" value="Register">
</form>
</body>
</html>
