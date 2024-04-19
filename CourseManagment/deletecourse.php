<?php
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['isAdmin'] != 1) {
    header("Location: homepage.php");
    die();
}
require_once("../_connect.php");
$courseID = $_GET['id'];
$stmt = $connect->prepare("DELETE FROM CourseDetails WHERE courseID = ?");
$stmt->bind_param("i", $courseID);
$stmt->execute();
$stmt->close();
header("Location: managecourses.php");