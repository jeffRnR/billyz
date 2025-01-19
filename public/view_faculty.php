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

        // Fetch the faculty member's details
        $stmt = $conn->prepare("SELECT * FROM faculty WHERE faculty_id = ?");
        $stmt->bind_param("i", $faculty_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo "<div class='faculty-details'>";
            echo "<h2>Faculty Details</h2>";
            echo "<p><strong>First Name:</strong> " . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p><strong>Last Name:</strong> " . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($row['dob'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p><strong>Address:</strong> " . htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p><strong>Hire Date:</strong> " . htmlspecialchars($row['hire_date'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p><strong>Department:</strong> " . htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "</div>";
        } else {
            echo "<div class='message error'>Faculty member not found.</div>";
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