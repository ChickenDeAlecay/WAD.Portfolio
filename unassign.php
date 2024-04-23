<?php
//start the session
session_start();

include('_connect.php');

//get courseId from the URL
$courseId = $_GET['courseId'];

//get userId from the session
$userId = $_SESSION['userID'];

$sql = "DELETE FROM RelationalTable WHERE CourseID = ? AND UserID = ?";

if ($stmt = mysqli_prepare($connect, $sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $courseId, $userId);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to homepage
        header("Location: homepage.php");
        exit();
    } else {
        echo "Something went wrong. Please try again later.";
    }
}

// Close statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($connect);
