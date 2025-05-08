<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$enrollment_id = intval($_GET['id']);
mysqli_query($conn, "UPDATE enrollments SET completion_status = 'completed' WHERE enrollment_id = $enrollment_id");
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
