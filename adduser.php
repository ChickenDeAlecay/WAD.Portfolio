<?php

if(!empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && 
    !empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && !empty($_POST['newFirstName'])){

        //This will include our '_connect.php' file so we can access our database connection.
        include("_connect.php");

        //These two variables with contain the username and the password that the user entered on the login page.
        $firstName = mysqli_real_escape_string($connect, $_POST['newFirstName']);
        $lastName = mysqli_real_escape_string($connect, $_POST['newLastName']);
        $jobTitle = mysqli_real_escape_string($connect, $_POST['newJobTitle']);
        $email = mysqli_real_escape_string($connect, $_POST['newEmail']);
        $username = mysqli_real_escape_string($connect, $_POST['newUsername']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if(isset($_POST['checkAdmin'])){
            $isAdmin = 1;
        }
        else{
            $isAdmin = 0;
        }

        //This is the SQL query that we are going to use to ensure that the username and password are correct.
        $SQL = "INSERT INTO UserDetails (firstName, lastName, jobTitle, email, username, password, isAdmin) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $connect->prepare($SQL);

        // Bind parameters
        $stmt->bind_param("ssssssi", $firstName, $lastName, $jobTitle, $email, $username, $password, $isAdmin);

        // Execute the prepared statement
        $stmt->execute();

        // Close the statement
        $stmt->close();
}else{
    //If the credentials were not entered,
    //we will send the user back to the login page with an error message.
    $errorMessage = urlencode("All details not provided");
    header("Location: register.php?msg=" . $errorMessage);

    die();
}