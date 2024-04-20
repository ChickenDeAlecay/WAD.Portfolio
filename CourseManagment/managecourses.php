<?php
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['isAdmin'] != 1) {
    header("Location: homepage.php");
    die();
}
require_once("../_connect.php");
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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
            <a class="nav-link active" aria-current="page" href="../homepage.php">Home</a>
          </li>
          <?php
          if ($_SESSION['isAdmin'] == 0) {
          } else {
            echo '<li class="nav-item">
                    <a class="nav-link" href="./managecourses.php">Manage Courses</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../UserManagment/manageusers.php">Manage Users</a>
                  </li>';
          }
          ?>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
        <span class="navbar-text">
          Training Platform
        </span>
      </div>
    </div>
  </nav>

<body>
    <div class="container">
        <h1>Manage Courses</h1>
        <a href="createcourse.php" class="btn btn-primary">Add Course</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Course Description</th>
                    <th>Actions</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $connect->prepare("SELECT * FROM Courses");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['CourseName'] . '</td>';
                    echo '<td>' . $row['CourseDescription'] . '</td>';
                    echo '<td>';
                    echo '<a href="editcourse.php?id=' . $row['CourseID'] . '" class="btn btn-warning">Edit</a> ';
                    echo '<a href="deletecourse.php?id=' . $row['CourseID'] . '" class="btn btn-danger">Delete</a>';
                    echo '</td>';
                    echo '<td>';
                    echo '<div class="accordion" id="accordionExample' . $row['CourseID'] . '">';
                    echo '<div class="accordion-item">';
                    echo '<h2 class="accordion-header" id="heading' . $row['CourseID'] . '">';
                    echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#users' . $row['CourseID'] . '" aria-expanded="false" aria-controls="users' . $row['CourseID'] . '">View Users</button>';
                    echo '</h2>';
                    echo '<div id="users' . $row['CourseID'] . '" class="accordion-collapse collapse" aria-labelledby="heading' . $row['CourseID'] . '" data-bs-parent="#accordionExample' . $row['CourseID'] . '">';
                    echo '<div class="accordion-body">';
                    $stmt2 = $connect->prepare("SELECT UserDetails.username FROM RelationalTable JOIN UserDetails ON RelationalTable.UserID = UserDetails.userID WHERE RelationalTable.CourseID = ?");
                    $stmt2->bind_param("i", $row['CourseID']);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        echo $row2['username'] . '<br>';
                    }
                    $stmt2->close();
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</td>';
                }
                $stmt->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>