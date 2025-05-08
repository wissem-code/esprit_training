<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$courses = mysqli_query($conn, "SELECT * FROM courses WHERE instructor_id = $teacher_id");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Courses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <img src="images/logo_esprit_training.png" class="logo" alt="Logo">
    <h1 class="slogan"><span class="black">Train. Track.</span><span class="red"> Transform.</span></h1>
</div>

<div class="container">
    <h2>My Courses</h2>
    <?php if (mysqli_num_rows($courses) > 0): ?>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($courses)): ?>
                <li>
                    <strong><?= htmlspecialchars($row['title']) ?></strong><br>
                    <small><?= htmlspecialchars($row['description']) ?></small><br>
                    <a href="view_enrollments.php?course_id=<?= $row['course_id'] ?>">View Enrollments</a>
                </li><br>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You haven’t added any courses yet.</p>
    <?php endif; ?>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>
