<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$course_id = intval($_GET['course_id']);
$query = "
    SELECT u.user_id, u.name, e.enrollment_id, e.completion_status
    FROM enrollments e
    JOIN users u ON e.user_id = u.user_id
    WHERE e.course_id = $course_id
";
$students = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Enrollments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <img src="images/logo_esprit_training.png" class="logo" alt="Logo">
    <h1 class="slogan"><span class="black">Train. Track.</span><span class="red"> Transform.</span></h1>
</div>

<div class="container">
    <h2>Enrolled Students</h2>
    <?php if (mysqli_num_rows($students) > 0): ?>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($students)): ?>
                <li>
                    <?= htmlspecialchars($row['name']) ?> -
                    Status: <?= $row['completion_status'] ?>
                    <?php if ($row['completion_status'] !== 'completed'): ?>
                        | <a href="mark_complete.php?id=<?= $row['enrollment_id'] ?>">Mark Complete</a>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No students enrolled yet.</p>
    <?php endif; ?>
    <p><a href="my_courses.php">Back to My Courses</a></p>
</div>
</body>
</html>
