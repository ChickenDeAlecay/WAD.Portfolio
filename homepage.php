<?php

session_start();

if(isset($_SESSION['userID'])){

    require_once("_connect.php");


    ?>

    <!DOCTYPE html>

    <html lang="en" data-bs-theme="dark">
      <head> 
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
              <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
            </li>
            <?php
                if($_SESSION['isAdmin'] == 0){
                }else{
                    echo'<li class="nav-item">
                    <a class="nav-link" href="register.php">Register User</a>
                    </li>';
                }
              ?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
          <span class="navbar-text">
            Training Platform
          </span>
        </div>
      </div>
    </nav>
    </html>
  <?php

    }

    $SQL = "SELECT * FROM Courses";
    $result = mysqli_query($connect, $SQL);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        $courseName = $row["CourseName"];
        $courseDescription = $row["CourseDescription"];
        $userCount = $row["UserCount"];
        $EstimatedTime = $row["EstimatedTime"];
        $link = $row["Link"];

        echo '<div class="col-sm-6 col-md-3">
                    <div class="caption">
                    <h5>'.$courseName.'</h5>
                    <p>'.$courseDescription.'</p>
                    <a href="'.$link.'" class=btn btn-success btn-lg btn-block" role="button"><strong>Go to Course</strong></a> ';
      }
    }

    ?>

    <html>
      </div>
        </div>
          </div>
        </div>
      </body>
    </html>