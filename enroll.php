<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$msg = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id'];

    $check = mysqli_query($conn, "SELECT * FROM enrollments WHERE user_id=$user_id AND course_id=$course_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO enrollments (user_id, course_id, completion_status) VALUES ($user_id, $course_id, 'in_progress')");
        $msg = "Enrolled successfully!";
    } else {
        $msg = "You are already enrolled in this course.";
    }
}

$courses = mysqli_query($conn, "SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Enroll in Course</title>
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
    <h2>Enroll in a Course</h2>
    <?php if ($msg) echo "<p style='color:green;'>$msg</p>"; ?>
    <form method="post">
        <select name="course_id" required>
            <option value="">Select a Course</option>
            <?php while ($row = mysqli_fetch_assoc($courses)): ?>
                <option value="<?= $row['course_id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
            <?php endwhile; ?>
        </select>
        <input type="submit" value="Enroll">
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>
