<?php
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['isAdmin'] != 1) {
  header("Location: homepage.php");
  die();
}
require_once("../_connect.php");
require_once("./addcourse.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $escapedStrings = escapeStrings($connect, $_POST);
  checkRequiredPostData(['newCourseName', 'newCourseDescription', 'courseID']);
  $courseName = $escapedStrings['newCourseName'];
  $courseDescription = $escapedStrings['newCourseDescription'];
  $courseID = $_POST['courseID'];
  $SQL = "UPDATE Courses SET CourseName = ?, CourseDescription = ?, StartDate = ? WHERE CourseID = ?";
  $stmt = $connect->prepare($SQL);
  $stmt->bind_param("sssi", $courseName, $courseDescription, $startDate, $courseID);
  $stmt->execute();
  $stmt->close();
  header("Location: managecourses.php");
} else {
  if (!isset($_GET['id'])) {
    redirectWithError("Course ID not provided");
    die();
  }
  $courseID = $_GET['id'];
  $stmt = $connect->prepare("SELECT * FROM Courses WHERE CourseID = ?");
  $stmt->bind_param("i", $courseID);
  $stmt->execute();
  $result = $stmt->get_result();
  $course = mysqli_fetch_assoc($result);
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <title>Dashboard</title>
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
<div class="container">
  <h1>Edit Course</h1>
  <form method="post" action="editcourse.php">
    <input type="hidden" name="courseID" value="<?php echo $course['CourseID']; ?>">
    <div class="mb-3">
      <label class="form-label">Course Name</label>
      <input type="text" class="form-control" name="newCourseName" value="<?php echo $course['CourseName']; ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Course Description</label>
      <input type="text" class="form-control" name="newCourseDescription" value="<?php echo $course['CourseDescription']; ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Start Date</label>
      <input type="date" class="form-control" name="startDate" value="<?php echo $course['StartDate']; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
</body>

</html>