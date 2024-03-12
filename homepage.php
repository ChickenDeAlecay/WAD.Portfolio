<?php

session_start();

if(isset($_SESSION['userID']) && isset($_SESSION['firstName'])){

    ?>

<!DOCTYPE html>

<html lang="en" data-bs-theme="dark">
   <head> 
    <title>HOME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>User Homepage</title>
   </head>

   <body>
    <h1>User Homepage</h1>
    <h2>Hello, <?php echo $_SESSION['firstName'];?></h2>
    <a href="logout.php">Logout</a>
    </body>
</html>

<?php

}else{
    header("Location: index.php");
}