<?php

session_start();

if(isset($_SESSION['userID']) && isset($_SESSION['username'])){

    ?>

<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
          <a class="nav-link" href="registernewuser.php">Register User</a>
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
  <form action="./auth.php" method="post">
    <div class="mb-3 lg-2">
      <label for="newFirstName" class="form-label">First Name</label>
      <input type="text" class="form-control" name="newFirstName">
    </div>
    <div class="mb-3 lg-2">
      <label for="newLastName" class="form-label">Last name</label>
      <input type="text" class="form-control" name="newLastName">
    </div>
    <div class="mb-3 lg-2">
      <label for="newEmail" class="form-label">Email</label>
      <input type="text" class="form-control" name="newEmail">
    </div>
    <div class="mb-3">
    <label for="jobTitle" class="form-label">Job Title</label>
    <input class="form-control" list="jobTitles" id="newJobtitle" placeholder="Type to search...">
    <datalist id="jobTitles">
        <option value="Project Manager">
        <option value="HR">
        <option value="Software Engineer">
        <option value="Electrical Engineer">
    </datalist>
    </div>
    <div class="mb-3 lg-2">
      <label for="newUsername" class="form-label">Username</label>
      <input type="text" class="form-control" name="newUsername">
    </div>
    <div class="mb-3 lg-2">
      <label for="newPassword" class="form-label">Password</label>
      <input type="password" class="form-control" name="password">
    </div>
    <div class="mb-3 lg-2">
      <label for="confirmPassword" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

<?php

}else{
    header("Location: login.php");
}