<?php

    //This will include our '_connect.php' file so we can access our database connection.
    require_once("_connect.php");

    //Check that the user has provided both a username and a password.
    if (!isset($_POST['username']) || !isset($_POST['password']))
    {
        //If the credentials were not entered or incorrect,
        //we will send the user back to the login page with an error message.
        $errorMessage = urlencode("Username or Password not provided");
        header("Location: login.php?msg=" . $errorMessage);
        die();
    }

    $captcha = $_POST['token'];
    $secretKey = '6LcfI54pAAAAAEfZArTIEPY7L1hUq8TKTX3M_134';
    $reCAPTCHA = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha)));

    //var_dump($reCAPTCHA);

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

        $hashedPassword = md5($password);

        //This is the SQL query that we are going to use to ensure that the username and password are correct.
       // $SQL = "SELECT * FROM `UserDetails` WHERE username = '$username' AND password = '$hashedPassword'";   
        
        $stmt = $connect->prepare("SELECT * FROM `UserDetails` WHERE username = ? AND password = ?");

        // Bind parameters
        $stmt->bind_param("ss", $username, $hashedPassword);

        // Execute the prepared statement
        $stmt->execute();

        //This will run the query in our database using the database connection from 'connect.php'.
        $result = $stmt->get_result();

        //We can check if a match was found by checking if a single row was
        //returned to us from the database using the 'mysqli_num_rows()' function.
        if ($result->num_rows == 1)
        {
                $row = $result->fetch_assoc();

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

                //Redirect the authenticated user to the index page.
                // header("Location: homepage.php");
                die("1");
            
        }else{
            //If the credentials were not entered or incorrect,
            //we will send the user back to the login page with an error message.
            $errorMessage = urlencode("Invalid Username or Password");
            header("Location: login.php?msg=" . $errorMessage);

            die();
        }
        $stmt->close();

?>