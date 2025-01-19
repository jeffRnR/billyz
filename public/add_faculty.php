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
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $hire_date = mysqli_real_escape_string($conn, $_POST['hire_date']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);

        $sql = "INSERT INTO faculty (first_name, last_name, dob, address, phone, hire_date, department) 
                VALUES ('$first_name', '$last_name', '$dob', '$address', '$phone', '$hire_date', '$department')";

        if (mysqli_query($conn, $sql)) {
            echo "New faculty member added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        // Display the form
        ?>
        <div class="form-container">
            <h2>Add Faculty Member</h2>
            <form method="post" action="">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="hire_date">Hire Date:</label>
                <input type="date" id="hire_date" name="hire_date" required>

                <label for="department">Department:</label>
                <input type="text" id="department" name="department">

                <button type="submit">Add Faculty Member</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>