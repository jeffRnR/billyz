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
            $first_name = htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8');
            $last_name = htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8');
            $dob = htmlspecialchars($row['dob'], ENT_QUOTES, 'UTF-8');
            $address = htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8');
            $phone = htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8');
            $hire_date = htmlspecialchars($row['hire_date'], ENT_QUOTES, 'UTF-8');
            $department = htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8');
        } else {
            echo "<div class='message error'>Faculty member not found.</div>";
            exit();
        }

        $stmt->close();
    } else {
        echo "<div class='message error'>Invalid request.</div>";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $faculty_id = $_POST['faculty_id'];
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $hire_date = mysqli_real_escape_string($conn, $_POST['hire_date']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);

        $sql = "UPDATE faculty SET first_name = '$first_name', last_name = '$last_name', dob = '$dob', address = '$address', phone = '$phone', hire_date = '$hire_date', department = '$department' WHERE faculty_id = $faculty_id";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='message success'>Faculty member updated successfully.</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    }
    ?>

    <div class="form-container">
        <h2>Edit Faculty Member</h2>
        <form method="post" action="">
            <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>

            <label for="hire_date">Hire Date:</label>
            <input type="date" id="hire_date" name="hire_date" value="<?php echo $hire_date; ?>" required>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" value="<?php echo $department; ?>">

            <button type="submit">Update Faculty Member</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>