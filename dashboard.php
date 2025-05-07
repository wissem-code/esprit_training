<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h2>
    <p>You are logged in as <strong><?= $_SESSION['role'] ?></strong>.</p>

    <ul>
        <li><a href="enroll.php">Enroll in a Course</a></li>
        <li><a href="certificate.php">My Certificates</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
