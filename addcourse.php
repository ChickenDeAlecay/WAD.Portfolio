<?php
function escapeStrings($connect, $strings)
{
    $escapedStrings = [];
    foreach ($strings as $key => $value) {
        $escapedStrings[$key] = mysqli_real_escape_string($connect, $value);
    }
    return $escapedStrings;
}
function isPostDataEmpty($keys)
{
    foreach ($keys as $key) {
        if (empty($_POST[$key])) {
            return true;
        }
    }
    return false;
}
function redirectWithError($errorMessage)
{
    header("Location: createcourse.php?msg=" . urlencode($errorMessage));
    die();
}
if (isPostDataEmpty(['courseName', 'courseDescription', 'estimatedTime'])) {
    redirectWithError("All details not provided");
}
include("_connect.php");
$escapedStrings = escapeStrings($connect, $_POST);
$courseName = $escapedStrings['courseName'];
$courseDescription = $escapedStrings['courseDescription'];
$estimatedTime = $escapedStrings['estimatedTime'];
$SQL = "INSERT INTO Courses (CourseName, CourseDescription, EstimatedTime) 
VALUES (?, ?, ?)";
$stmt = $connect->prepare($SQL);
$stmt->bind_param("ssi", $courseName, $courseDescription, $estimatedTime);
$stmt->execute();
$stmt->close();

header("Location: createcourse.php");
?>