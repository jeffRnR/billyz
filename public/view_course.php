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
    $course_id = $_GET['id'];

    $sql = "SELECT * FROM Courses WHERE course_id=$course_id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='course-details'>";
        echo "<h2>Course Details</h2>";
        echo "<p><strong>Course Name:</strong> " . htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Course Description:</strong> " . nl2br(htmlspecialchars($row['course_description'], ENT_QUOTES, 'UTF-8')) . "</p>";
        echo "<p><strong>Credits:</strong> " . htmlspecialchars($row['credits'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Department:</strong> " . htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "</div>";
    } else {
        echo "<div class='message error'>Course not found.</div>";
    }

    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>