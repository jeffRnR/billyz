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
    $sql = "SELECT * FROM Grades";
    $result = mysqli_query($conn, $sql);

    echo "<h2>Grade List</h2>";
    echo "<table class='grades-table'>";
    echo "<tr><th>Grade ID</th><th>Enrollment ID</th><th>Grade</th><th>Comments</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['grade_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['enrollment_id'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['grade'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['comments'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>