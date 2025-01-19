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
    $sql = "SELECT * FROM Enrollments";
    $result = mysqli_query($conn, $sql);

    echo "<h2>Enrollment List</h2>";
    echo "<table class='enrollments-table'>";
    echo "<tr><th>Enrollment ID</th><th>Student ID</th><th>Course ID</th><th>Enrollment Date</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['enrollment_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['student_id'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['course_id'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['enrollment_date'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>