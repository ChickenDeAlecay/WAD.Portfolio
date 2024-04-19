<?php
require_once("_connect.php");

// Fetch all course IDs from the Courses table
$stmt = $connect->prepare("SELECT CourseID FROM Courses");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $courseID = $row["CourseID"];

    // Count the number of unique user IDs associated with the course ID
    $stmt2 = $connect->prepare("SELECT COUNT(DISTINCT UserID) as UserCount FROM Courses LEFT JOIN RelationalTable ON Courses.CourseID = RelationalTable.CourseID WHERE Courses.CourseID = ?");
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
?>