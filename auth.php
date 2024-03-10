<?php

    //Check that the user has provided both a username and a password.
    if (isset($_POST['username']) && isset($_POST['password']))
    {
        //This will include our '_connect.php' file so we can access our database connection.
        include("_connect.php");

        //These two variables with contain the username and the password that the user entered on the login page.
        $username = $_POST['username'];
        $password = $_POST['password'];

        //We are using 'mysqli_real_escape_string()' to help prevent against SQL Injection.
        //This function will put backslashes in front of potentially unsafe characters (' " `).
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);

        //This is the SQL query that we are going to use to ensure that the username and password are correct.
        $SQL = "SELECT * FROM `UserDetails` WHERE username = '$username' AND password = '$password'";
        //$SQL = $connect->prepare("SELECT * FROM `UserDetails` WHERE `username` = (firstname) AND `password` = (passord) VALUES (?, ?)");
        //$SQL->bind_param("ss", $username, $password);
    

        //This will run the query in our database using the database connection from 'connect.php'.
        $query = mysqli_query($connect, $SQL);

        //We can check if a match was found by checking if a single row was
        //returned to us from the database using the 'mysqli_num_rows()' function.
        if (mysqli_num_rows($query) == 1)
        {
            $row = mysqli_fetch_assoc($query);

            if($row['username'] == $username && $row['password'] == $password){
                //We are using sessions to store information, so we can access them across multiple pages.
                //All session data is stored on the server and cannot be modified like a cookie.
                $_SESSION['username'] = $row['username'];

                $_SESSION['firstName'] = $row['firstName'];

                $_SESSION['lastName'] = $row['lastName'];

                $_SESSION['userID'] = $row['userID'];

                //Redirect the authenticated user to the index page.
                header("Location: homepage.php");
                exit();
            }
            
        }
    }

    //If the credentials were not entered or incorrect,
    //we will send the user back to the login page with an error message.
    $errorMessage = urlencode("Invalid Username or Password");
    header("Location: auth.php?msg=" . $errorMessage);

?>