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
    $enrollment_id = $_GET['id'];
    $sql = "SELECT * FROM Enrollments WHERE enrollment_id=$enrollment_id";
    $result = mysqli_query($conn, $sql);
    $enrollment = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];
        $enrollment_date = $_POST['enrollment_date'];

        $sql = "UPDATE Enrollments SET 
                student_id='$student_id', 
                course_id='$course_id', 
                enrollment_date='$enrollment_date' 
                WHERE enrollment_id=$enrollment_id";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='message success'>Enrollment information updated successfully!</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    } else {
        ?>
        <div class="form-container">
            <h2>Update Enrollment Information</h2>
            <form action="update_enrollment.php?id=<?php echo $enrollment['enrollment_id']; ?>" method="POST">
                <label for="student_id">Student ID:</label>
                <input type="number" id="student_id" name="student_id"
                    value="<?php echo htmlspecialchars($enrollment['student_id'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="course_id">Course ID:</label>
                <input type="number" id="course_id" name="course_id"
                    value="<?php echo htmlspecialchars($enrollment['course_id'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="enrollment_date">Enrollment Date:</label>
                <input type="date" id="enrollment_date" name="enrollment_date"
                    value="<?php echo htmlspecialchars($enrollment['enrollment_date'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <button type="submit">Update Enrollment</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>