<?php

session_start();

if(isset($_SESSION['userID']) && isset($_SESSION['username'])){

    ?>

<?php

}else{
    header("Location: index.php");
}