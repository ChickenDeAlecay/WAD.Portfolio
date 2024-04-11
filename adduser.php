<?php

if(!empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && 
    !empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && !empty($_POST['newFirstName'])){

        //This will include our '_connect.php' file so we can access our database connection.
        include("_connect.php");

        //These two variables with contain the username and the password that the user entered on the login page.
        $firstName = $_POST['newFirstName'];
        $lastName = $_POST['newLastName'];
        $jobTitle = $_POST['newJobTitle'];
        $email = $_POST['newEmail'];
        $username = $_POST['newUsername'];
        $password = $_POST['password'];
        if(isset($_POST['checkAdmin'])){
            $isAdmin = 1;
        }
        else{
            $isAdmin = 0;
        }

        //We are using 'mysqli_real_escape_string()' to help prevent against SQL Injection.
        //This function will put backslashes in front of potentially unsafe characters (' " `).
        $firstName = mysqli_real_escape_string($connect, $_POST['newFirstName']);
        $lastName = mysqli_real_escape_string($connect, $_POST['newLastName']);
        $jobTitle = mysqli_real_escape_string($connect, $_POST['newJobTitle']);
        $email = mysqli_real_escape_string($connect, $_POST['newEmail']);
        $username = mysqli_real_escape_string($connect, $_POST['newUsername']);
        $password = password_hash(mysqli_real_escape_string($connect, $_POST['password']), PASSWORD_BCRYPT);

        //This is the SQL query that we are going to use to ensure that the username and password are correct.
        $SQL = "INSERT INTO `UserDetails`(`firstName`, `lastName`, `jobTitle`, `email`, `username`, `password`, `isAdmin`) 
        VALUES ('$firstName','$lastName','$jobTitle','$email,'$username','$password','$isAdmin')";

        //This will run the query in our database using the database connection from 'connect.php'.
        $query = mysqli_query($connect, $SQL);
}else{
    //If the credentials were not entered,
    //we will send the user back to the login page with an error message.
    $errorMessage = urlencode("All details not provided");
    header("Location: register.php?msg=" . $errorMessage);

    die();
}