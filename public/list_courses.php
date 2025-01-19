<!DOCTYPE html>
<html>

<head>
    <title>College Management System</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/db_connect.php'; ?>

    <?php
    $sql = "SELECT * FROM Courses";
    $result = mysqli_query($conn, $sql);

    echo "<h2>Course List</h2>";
    echo "<table class='courses-table'>";
    echo "<tr><th>Course ID</th><th>Course Name</th><th>Details</th><th>Update</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['course_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td><a href='view_course.php?id=" . $row['course_id'] . "'>View</a></td>";
        echo "<td><a href='update_course.php?id=" . $row['course_id'] . "'>Update</a></td>";
        echo "</tr>";
    }

    echo "</table>";
    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>