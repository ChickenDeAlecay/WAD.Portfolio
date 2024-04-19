<?php
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['isAdmin'] != 1) {
    header("Location: homepage.php");
    die();
}
require_once("../_connect.php");
$userID = $_GET['id'];
$stmt = $connect->prepare("DELETE FROM UserDetails WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();
header("Location: manageusers.php");