<?php

session_start();

if(isset($_SESSION['userID']) && isset($_SESSION['firstName'])){

    ?>

<!DOCTYPE html>

<html lang="en" data-bs-theme="dark">
   <head> 
    <title>HOME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   </head>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Homepage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admindashboard.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="courses.php">Courses</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="register.php">Register User</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
        <span class="navbar-text">
            Admin Dashboard
        </span>
        </div>
    </div>
    </nav>

   <body>    
    <h2>Hello, <?php echo $_SESSION['firstName'];?></h2>
    </body>
</html>

<?php

}else{
    header("Location: login.php");
}