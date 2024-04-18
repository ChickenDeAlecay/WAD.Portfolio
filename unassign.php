<?php
// unassign.php

// Start the session
session_start();

// Include your database connection file here
include('_connect.php');

// Get the courseId from the URL
$courseId = $_GET['courseId'];

// Get the userId from the session
$userId = $_SESSION['userID'];

// Prepare the SQL statement
$sql = "DELETE FROM RelationalTable WHERE CourseID = ? AND UserID = ?";

// Prepare the statement
if ($stmt = mysqli_prepare($connect, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ii", $courseId, $userId);

    // Attempt to execute the prepared statement
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
