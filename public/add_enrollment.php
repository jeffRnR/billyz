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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process the form submission
        $course_name = $_POST['course_name'];
        $course_description = $_POST['course_description'];
        $credits = $_POST['credits'];
        $department = $_POST['department'];

        $sql = "INSERT INTO Courses (course_name, course_description, credits, department) VALUES ('$course_name', '$course_description', '$credits', '$department')";

        if (mysqli_query($conn, $sql)) {
            echo "New course added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        // Display the form
        ?>
        <div class="form-container">
            <h2>Add New Course</h2>
            <form action="add_course.php" method="POST">
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="course_name" required>

                <label for="course_description">Course Description:</label>
                <textarea id="course_description" name="course_description" required></textarea>

                <label for="credits">Credits:</label>
                <input type="number" id="credits" name="credits" required>

                <label for="department">Department:</label>
                <input type="text" id="department" name="department" required>

                <button type="submit">Add Course</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>