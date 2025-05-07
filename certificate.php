<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get completed courses only
$sql = "SELECT c.title
        FROM enrollments e
        JOIN courses c ON e.course_id = c.course_id
        WHERE e.user_id = $user_id AND e.completion_status = 'completed'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>My Certificates</title>
</head>
<body>
<h2>My Certificates</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li>
                Certificate: <strong><?= htmlspecialchars($row['title']) ?></strong><br>
                Status: Completed ✅
            </li><br>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>You have no completed courses yet.</p>
<?php endif; ?>

<p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
