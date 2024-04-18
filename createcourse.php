<?php
session_start();
if (isset($_SESSION['userID']) && isset($_SESSION['username'])) {
?>
    <html lang="en" data-bs-theme="dark">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Course</title>
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
                        <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="createcourse.php">Create Course</a>
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
        <div class="container">
            <form action="./addcourse.php" method="post">
                <div class="mb-3 lg-2">
                    <label for="courseName" class="form-label">Course Name</label>
                    <input type="text" class="form-control" name="courseName">
                </div>
                <div class="mb-3 lg-2">
                    <label for="courseDescription" class="form-label">Course Description</label>
                    <textarea class="form-control" name="courseDescription"></textarea>
                </div>
                <div class="mb-3 lg-2">
                    <label for="estimatedTime" class="form-label">Estimated Time (hrs)</label>
                    <input type="number" class="form-control" name="estimatedTime">
                </div>
                <button type="submit" class="btn btn-primary">Create Course</button>
            </form>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
}
?>