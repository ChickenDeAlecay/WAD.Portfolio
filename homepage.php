<?php

session_start();

if(isset($_SESSION['userID']) && isset($_SESSION['firstName'])){

    ?>

<!DOCTYPE html>

<html>
   <head> 
    <title>HOME</title>
   </head>

   <body>
    <h1>Hello, <?php echo $_SESSION['firstName'];?></h1>
    <a href="logout.php">Logout</a>
    </body>
</html>

<?php

}else{
    header("Location: index.php");
}