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
    <body>    
        <div class="content-wrap">
          <div class="container clearfix">
            <div class="bottommargin clearfix">
              <div class="row">
            <div class="h3">Assigned Courses</div>
    </html>

  <?php
    $userID = $_SESSION['userID'];
    $queryRelational = "SELECT * FROM RelationalTable WHERE UserID = $userID";
    $resultRelational = mysqli_query($connect, $queryRelational);

    $selectedCourseIDs = [];
    if(mysqli_num_rows($resultRelational) > 0){
      while($rowRelational = mysqli_fetch_assoc($resultRelational)){

        $CourseID = $rowRelational["CourseID"];
        $selectedCourseIDs[] = $CourseID;
        $queryCourses = "SELECT * FROM Courses WHERE CourseID = $CourseID";
        $resultCourse = mysqli_query($connect, $queryCourses);

        $rowCourse = mysqli_fetch_assoc($resultCourse);
        $courseName = $rowCourse["CourseName"];
        $courseDescription = $rowCourse["CourseDescription"];
        $userCount = $rowCourse["UserCount"];
        $EstimatedTime = $rowCourse["EstimatedTime"];
        $link = $rowCourse["Link"];

        echo '<div class="col-sm-6 col-md-3">
                <div class="course-box">
                    <div class="caption">
                        <h5>'.$courseName.'</h5>
                        <p>'.$courseDescription.'</p>
                        <a href="'.$link.'" class="btn btn-success btn-lg btn-block" role="button"><strong>Go to Course</strong></a>
                    </div>
                </div>
            </div>';
      }
    }

    $selectedCourseIDsString = implode(',', $selectedCourseIDs);
    $queryCoursesNotSelected = "SELECT * FROM Courses WHERE CourseID NOT IN ($selectedCourseIDsString)";
    $resultCoursesNotSelected = mysqli_query($connect, $queryCoursesNotSelected);

    echo '<div class="h3">Unassigned Courses</div>';
    while($rowCourseNotSelected = mysqli_fetch_assoc($resultCoursesNotSelected)){
      $courseName = $rowCourseNotSelected["CourseName"];
      $courseDescription = $rowCourseNotSelected["CourseDescription"];
      $userCount = $rowCourseNotSelected["UserCount"];
      $EstimatedTime = $rowCourseNotSelected["EstimatedTime"];
      $link = $rowCourseNotSelected["Link"];
      echo '<div class="col-sm-6 col-md-3">
              <div class="course-box">
                  <div class="caption">
                      <h5>'.$courseName.'</h5>
                      <p>'.$courseDescription.'</p>
                      <a href="'.$link.'" class="btn btn-success btn-lg btn-block" role="button"><strong>Assign Course</strong></a>
                  </div>
              </div>
          </div>';
    }

    ?>

    <html>
      </div>
        </div>
          </div>
        </div>
      </body>
    </html>

    <?php
}
?>