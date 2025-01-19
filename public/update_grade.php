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
    $grade_id = $_GET['id'];
    $sql = "SELECT * FROM Grades WHERE grade_id=$grade_id";
    $result = mysqli_query($conn, $sql);
    $grade = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $enrollment_id = $_POST['enrollment_id'];
        $grade_value = $_POST['grade'];
        $comments = $_POST['comments'];

        $sql = "UPDATE Grades SET 
                enrollment_id='$enrollment_id', 
                grade='$grade_value', 
                comments='$comments' 
                WHERE grade_id=$grade_id";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='message success'>Grade information updated successfully!</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    } else {
        ?>
        <div class="form-container">
            <h2>Update Grade Information</h2>
            <form action="update_grade.php?id=<?php echo $grade['grade_id']; ?>" method="POST">
                <label for="enrollment_id">Enrollment ID:</label>
                <input type="number" id="enrollment_id" name="enrollment_id"
                    value="<?php echo htmlspecialchars($grade['enrollment_id'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="grade">Grade:</label>
                <input type="text" id="grade" name="grade"
                    value="<?php echo htmlspecialchars($grade['grade'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="comments">Comments:</label>
                <textarea id="comments"
                    name="comments"><?php echo htmlspecialchars($grade['comments'], ENT_QUOTES, 'UTF-8'); ?></textarea>

                <button type="submit">Update Grade</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>