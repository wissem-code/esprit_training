<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn,
    "SELECT c.title FROM enrollments e
     JOIN courses c ON e.course_id = c.course_id
     WHERE e.user_id = $user_id AND e.completion_status = 'completed'");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Certificates</title>
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
    <h2>My Certificates</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <ul>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li><strong><?= htmlspecialchars($row['title']) ?></strong> - Completed ✅</li>
        <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You haven’t completed any courses yet.</p>
    <?php endif; ?>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>
