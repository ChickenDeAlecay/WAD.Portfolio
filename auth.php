<?php

    //This will include our '_connect.php' file so we can access our database connection.
    require_once("_connect.php");

    //Check that the user has provided both a username and a password.
    if (!isset($_POST['username']) || !isset($_POST['password']))
    {
        //If the credentials were not entered or incorrect,
        //we will send the user back to the login page with an error message.
        $errorMessage = urlencode("Username or Password not provided");
        header("Location: index.php?msg=" . $errorMessage);
        die();
    }

    $captcha = $_POST['token'];
    $secretKey = '6LcfI54pAAAAAEfZArTIEPY7L1hUq8TKTX3M_134';
    $reCAPTCHA = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha)));

    // var_dump($reCAPTCHA);

    if ($reCAPTCHA->score <= 0.5)
    {
        die("You are a bot!");
    }

        //These two variables with contain the username and the password that the user entered on the login page.
        $username = $_POST['username'];
        $password = $_POST['password'];

        //We are using 'mysqli_real_escape_string()' to help prevent against SQL Injection.
        //This function will put backslashes in front of potentially unsafe characters (' " `).
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);

        //This is the SQL query that we are going to use to ensure that the username and password are correct.
        $SQL = "SELECT * FROM `UserDetails` WHERE username = '$username' AND password = '$password'";    

        //This will run the query in our database using the database connection from 'connect.php'.
        $query = mysqli_query($connect, $SQL);

        //We can check if a match was found by checking if a single row was
        //returned to us from the database using the 'mysqli_num_rows()' function.
        if (mysqli_num_rows($query) == 1)
        {
            $row = mysqli_fetch_assoc($query);

            if($row['username'] == $username && $row['password'] == $password){

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

                // if($row['isAdmin'] == true){
                //     header("Location: admindashboard.php");
                // }else{
                // //Redirect the authenticated user to the index page.
                // header("Location: homepage.php");
                // }
                echo true;
            }else{
                //If the credentials were not entered or incorrect,
                //we will send the user back to the login page with an error message.
                $errorMessage = urlencode("Invalid Username or Password");
                header("Location: index.php?msg=" . $errorMessage);

                die();
            }
            
        }else{
            //If the credentials were not entered or incorrect,
            //we will send the user back to the login page with an error message.
            $errorMessage = urlencode("Invalid Username or Password");
            header("Location: index.php?msg=" . $errorMessage);

            die();
        }


?>