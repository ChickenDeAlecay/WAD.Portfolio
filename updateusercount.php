<?php
require_once("_connect.php");

// Fetch all unique course IDs from the RelationalTable
$stmt = $connect->prepare("SELECT DISTINCT CourseID FROM RelationalTable");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $courseID = $row["CourseID"];

    // Count the number of unique user IDs associated with the course ID
    $stmt2 = $connect->prepare("SELECT COUNT(DISTINCT UserID) as UserCount FROM RelationalTable WHERE CourseID = ?");
    $stmt2->bind_param("i", $courseID);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $row2 = $result2->fetch_assoc();
    $userCount = $row2["UserCount"];

    // Update the UserCount column in the Courses table
    $stmt3 = $connect->prepare("UPDATE Courses SET UserCount = ? WHERE CourseID = ?");
    $stmt3->bind_param("ii", $userCount, $courseID);
    $stmt3->execute();
}

echo "User counts updated successfully.";
?>