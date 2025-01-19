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
    $course = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process the form submission
        $course_name = $_POST['course_name'];
        $course_description = $_POST['course_description'];
        $credits = $_POST['credits'];
        $department = $_POST['department'];

        $sql = "UPDATE Courses SET 
                course_name='$course_name', 
                course_description='$course_description', 
                credits='$credits', 
                department='$department' 
                WHERE course_id=$course_id";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='message success'>Course information updated successfully!</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    } else {
        // Display the form with existing course information
        ?>
        <div class="form-container">
            <h2>Update Course Information</h2>
            <form action="update_course.php?id=<?php echo $course['course_id']; ?>" method="POST">
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="course_name"
                    value="<?php echo htmlspecialchars($course['course_name'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="course_description">Course Description:</label>
                <textarea id="course_description" name="course_description"
                    required><?php echo htmlspecialchars($course['course_description'], ENT_QUOTES, 'UTF-8'); ?></textarea>

                <label for="credits">Credits:</label>
                <input type="number" id="credits" name="credits"
                    value="<?php echo htmlspecialchars($course['credits'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="department">Department:</label>
                <input type="text" id="department" name="department"
                    value="<?php echo htmlspecialchars($course['department'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <button type="submit">Update Course</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>