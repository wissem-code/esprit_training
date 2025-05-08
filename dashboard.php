<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header">
    <img src="images/logo_esprit_training.png" alt="Esprit Training Logo" class="logo">
    <h1 class="slogan">
        <span class="black">Train. Track.</span><span class="red"> Transform.</span>
    </h1>
</div>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h2>
    <p>You are logged in as <strong><?= $_SESSION['role'] ?></strong>.</p>

    <?php if ($_SESSION['role'] === 'student'): ?>
        <ul>
            <li><a href="enroll.php">Enroll in a Course</a></li>
            <li><a href="certificate.php">My Certificates</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

    <?php elseif ($_SESSION['role'] === 'teacher'): ?>
        <ul>
            <li><a href="add_course.php">Add a New Course</a></li>
            <li><a href="my_courses.php">My Courses</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>


    <?php else: ?>
        <ul>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>

