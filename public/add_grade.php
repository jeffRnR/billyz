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
        $enrollment_id = $_POST['enrollment_id'];
        $grade = $_POST['grade'];
        $comments = $_POST['comments'];

        $sql = "INSERT INTO Grades (enrollment_id, grade, comments) VALUES ('$enrollment_id', '$grade', '$comments')";

        if (mysqli_query($conn, $sql)) {
            echo "New grade added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        // Display the form
        ?>
        <div class="form-container">
            <h2>Add New Grade</h2>
            <form action="add_grade.php" method="POST">
                <label for="enrollment_id">Enrollment ID:</label>
                <input type="number" id="enrollment_id" name="enrollment_id" required>

                <label for="grade">Grade:</label>
                <input type="text" id="grade" name="grade" required>

                <label for="comments">Comments:</label>
                <textarea id="comments" name="comments"></textarea>

                <button type="submit">Add Grade</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>