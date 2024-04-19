<?php
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['isAdmin'] != 1) {
    header("Location: homepage.php");
    die();
}
require_once("../_connect.php");
require_once("./adduser.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $escapedStrings = escapeStrings($connect, $_POST);
    checkRequiredPostData(['newFirstName', 'newLastName', 'newJobTitle', 'newEmail', 'newUsername', 'userID']);
    $firstName = $escapedStrings['newFirstName'];
    $lastName = $escapedStrings['newLastName'];
    $jobTitle = $escapedStrings['newJobTitle'];
    $email = $escapedStrings['newEmail'];
    $username = $escapedStrings['newUsername'];
    $isAdmin = isset($_POST['checkAdmin']) ? 1 : 0;
    $userID = $_POST['userID'];
    $SQL = "UPDATE UserDetails SET firstName = ?, lastName = ?, jobTitle = ?, email = ?, username = ?, isAdmin = ? WHERE userID = ?";
    $stmt = $connect->prepare($SQL);
    $stmt->bind_param("ssssssi", $firstName, $lastName, $jobTitle, $email, $username, $isAdmin, $userID);
    $stmt->execute();
    $stmt->close();
    header("Location: manageusers.php");
} else {
    if (!isset($_GET['id'])) {
        redirectWithError("User ID not provided");
        die();
    }
    $userID = $_GET['id'];
    $stmt = $connect->prepare("SELECT * FROM UserDetails WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = mysqli_fetch_assoc($result);
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
                    <a class="nav-link" href="../CourseManagment/managecourses.php">Manage Courses</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="./manageusers.php">Manage Users</a>
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
    <h1>Edit User</h1>
    <form method="post" action="edituser.php">
        <input type="hidden" name="userID" value="<?php echo $user['userID']; ?>">
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="newFirstName" value="<?php echo $user['firstName']; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="newLastName" value="<?php echo $user['lastName']; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Job Title</label>
            <input type="text" class="form-control" name="newJobTitle" value="<?php echo $user['jobTitle']; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="newEmail" value="<?php echo $user['email']; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="newUsername" value="<?php echo $user['username']; ?>">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="checkAdmin" <?php echo $user['isAdmin'] ? 'checked' : ''; ?>>
            <label class="form-check-label">Admin</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>

</html>