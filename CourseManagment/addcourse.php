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

function checkRequiredPostData($requiredFields) {
    if (isPostDataEmpty($requiredFields)) {
        redirectWithError("All details not provided");
    }
}

function addCourse($connect) {
    include("../_connect.php");
    checkRequiredPostData(['courseName', 'courseDescription', 'estimatedTime', 'maxUsers']);
    $escapedStrings = escapeStrings($connect, $_POST);
    $courseName = $escapedStrings['courseName'];
    $courseDescription = $escapedStrings['courseDescription'];
    $estimatedTime = $escapedStrings['estimatedTime'];
    $maxUsers = $escapedStrings['maxUsers'];
    $SQL = "INSERT INTO Courses (CourseName, CourseDescription, EstimatedTime, MaxUsers) 
    VALUES (?, ?, ?, ?)";
    $stmt = $connect->prepare($SQL);
    $stmt->bind_param("ssii", $courseName, $courseDescription, $estimatedTime, $maxUsers);
    $stmt->execute();
    $stmt->close();

    header("Location: createcourse.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    addCourse($connect);
}
?>