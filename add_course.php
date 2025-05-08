<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $instructor_id = $_SESSION['user_id'];

    $sql = "INSERT INTO courses (title, description, instructor_id) VALUES ('$title', '$description', $instructor_id)";
    if (mysqli_query($conn, $sql)) {
        $msg = "Course added successfully.";
    } else {
        $msg = "Error adding course.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <img src="images/logo_esprit_training.png" class="logo" alt="Logo">
    <h1 class="slogan">
        <span class="black">Train. Track.</span><span class="red"> Transform.</span>
    </h1>
</div>

<div class="container">
    <h2>Add a New Course</h2>
    <?php if ($msg): ?>
        <p style="color: green;"><?= $msg ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="title" placeholder="Course Title" required>
        <textarea name="description" placeholder="Course Description" rows="4" style="width:100%;padding:10px;" required></textarea>
        <input type="submit" value="Add Course">
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>
