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
    header("Location: register.php?msg=" . urlencode($errorMessage));
    die();
}

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function checkRequiredPostData($requiredFields) {
    if (isPostDataEmpty($requiredFields)) {
        redirectWithError("All details not provided");
    }
}

include("../_connect.php");

function addUser($connect) {
    checkRequiredPostData(['newFirstName', 'newLastName', 'newJobTitle', 'newEmail', 'newUsername', 'password']);
    $escapedStrings = escapeStrings($connect, $_POST);
    $escapedStrings = escapeStrings($connect, $_POST);
    $firstName = $escapedStrings['newFirstName'];
    $lastName = $escapedStrings['newLastName'];
    $jobTitle = $escapedStrings['newJobTitle'];
    $email = $escapedStrings['newEmail'];
    $username = $escapedStrings['newUsername'];
    $password = hashPassword($_POST['password']);

    $isAdmin = isset($_POST['checkAdmin']) ? 1 : 0;

    $SQL = "INSERT INTO UserDetails (firstName, lastName, jobTitle, email, username, password, isAdmin) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($SQL);
    $stmt->bind_param("ssssssi", $firstName, $lastName, $jobTitle, $email, $username, $password, $isAdmin);
    $stmt->execute();
    $stmt->close();

    header("Location: createuser.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    addUser($connect);
}