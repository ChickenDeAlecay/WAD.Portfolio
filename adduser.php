<?php

if(!empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && 
    !empty($_POST['newFirstName']) && !empty($_POST['newFirstName']) && !empty($_POST['newFirstName'])){

}else{
    //If the credentials were not entered,
    //we will send the user back to the login page with an error message.
    $errorMessage = urlencode("All details not provided");
    header("Location: register.php?msg=" . $errorMessage);

    die();
}