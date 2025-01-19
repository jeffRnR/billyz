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
    if (isset($_GET['id'])) {
        $faculty_id = $_GET['id'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM faculty WHERE faculty_id = ?");
        $stmt->bind_param("i", $faculty_id);

        if ($stmt->execute()) {
            echo "<div class='message success'>Faculty member deleted successfully.</div>";
        } else {
            echo "<div class='message error'>Error deleting record: " . $conn->error . "</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='message error'>Invalid request.</div>";
    }

    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>