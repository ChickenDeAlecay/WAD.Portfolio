<?php
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['isAdmin'] != 1) {
    header("Location: homepage.php");
    die();
}
require_once("../_connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Course Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Course Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Users</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $connect->prepare("SELECT Courses.CourseName, GROUP_CONCAT(UserDetails.UserName) as Users FROM RelationalTable JOIN Courses ON RelationalTable.CourseID = Courses.CourseID JOIN Users ON RelationalTable.UserID = UserDetails.UserID GROUP BY Courses.CourseName");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['CourseName'] . '</td>';
                    echo '<td>' . $row['Users'] . '</td>';
                    echo '</tr>';
                }
                $stmt->close();
                ?>
            </tbody>
        </table>
        <a href="managecourses.php" class="btn btn-primary">Back to Manage Courses</a>
    </div>
</body>
</html>