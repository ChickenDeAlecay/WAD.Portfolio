<?php
//start the session
session_start();

//include database connection file
include('_connect.php');

//get courseId from the URL
$courseId = $_GET['courseId'];

//get userId from the session
$userId = $_SESSION['userID'];

$sql = "INSERT INTO RelationalTable (CourseID, UserID) VALUES (?, ?)";

if ($stmt = mysqli_prepare($connect, $sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $courseId, $userId);

    //attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        //redirect to homepage
        header("Location: homepage.php");
        exit();
    } else {
        echo "Something went wrong. Please try again later.";
    }
}

//close statement
mysqli_stmt_close($stmt);

//close connection
mysqli_close($connect);
