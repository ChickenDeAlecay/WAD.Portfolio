<?php

//This will include our '_connect.php' file so we can access our database connection.
require_once("_connect.php");

//Check that the user has provided both a username and a password.
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    //If the credentials were not entered or incorrect
    echo "Please enter both a username and password";

    die();
}

$captcha = $_POST['token'];
$secretKey = '6LcfI54pAAAAAEfZArTIEPY7L1hUq8TKTX3M_134';
$reCAPTCHA = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha)));

if ($reCAPTCHA->score <= 0.5) {
    die("You are a bot!");
}

//These two variables with contain the username and the password that the user entered on the login page.
$username = mysqli_real_escape_string($connect, $_POST['username']);
$password = trim($_POST['password']);

//This is the SQL query that we are going to use to ensure that the username is correct. 
$stmt = $connect->prepare("SELECT * FROM `UserDetails` WHERE username = ?");

// Bind parameters
$stmt->bind_param("s", $username);

// Execute the prepared statement
$stmt->execute();

//This will run the query in our database using the database connection from 'connect.php'.
$result = $stmt->get_result();

//We can check if a match was found by checking if a single row was
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    //echo "Form password: " . $password . "<br>";
    //echo "Hashed password from database: " . $row['password'] . "<br>";

    if (password_verify($password, $row['password'])) {
        session_start();
        //We are using sessions to store information, so we can access them across multiple pages.
        //All session data is stored on the server and cannot be modified like a cookie.
        $_SESSION['userID'] = $row['userID'];

        $_SESSION['username'] = $row['username'];

        $_SESSION['email'] = $row['email'];

        $_SESSION['firstName'] = $row['firstName'];

        $_SESSION['lastName'] = $row['lastName'];

        $_SESSION['jobTitle'] = $row['jobTitle'];

        $_SESSION['isAdmin'] = $row['isAdmin'];

        die("1");
    } else {
        //If the credentials were not entered or incorrect

        //echo "Password verify result: " . (password_verify($password, $row['password']) ? 'true' : 'false') . "<br>";

        echo "Invalid Username or Password";

        die();
    }
} else {
    //If the credentials were not entered or incorrect
    echo "Invalid Username or Password";

    die();
}
$stmt->close();
