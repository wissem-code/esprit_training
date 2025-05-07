<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$success = "";
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];

    // Check if already enrolled
    $check = mysqli_query($conn, "SELECT * FROM enrollments WHERE user_id=$user_id AND course_id=$course_id");
    if (mysqli_num_rows($check) > 0) {
        $error = "You are already enrolled in this course.";
    } else {
        $date = date('Y-m-d');
        $sql = "INSERT INTO enrollments (user_id, course_id, enrolled_date, completion_status)
                VALUES ($user_id, $course_id, '$date', 'in_progress')";
        if (mysqli_query($conn, $sql)) {
            $success = "Enrolled successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

// Fetch available courses
$courses = mysqli_query($conn, "SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>Enroll in a Course</title>
</head>
<body>
<h2>Enroll in a Course</h2>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<form method="post" action="">
    <label>Select Course:</label>
    <select name="course_id" required>
        <option value="">-- Choose a course --</option>
        <?php while ($row = mysqli_fetch_assoc($courses)): ?>
            <option value="<?= $row['course_id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
        <?php endwhile; ?>
    </select>
    <br><br>
    <input type="submit" value="Enroll">
</form>

<p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
