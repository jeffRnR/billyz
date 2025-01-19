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
    $sql = "SELECT * FROM faculty";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Faculty List</h2>";
        echo "<table class='faculty-table'>";
        echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>DOB</th><th>Address</th><th>Phone</th><th>Hire Date</th><th>Department</th><th>Action</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['faculty_id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['dob'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['hire_date'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td><a href='view_faculty.php?id=" . $row['faculty_id'] . "'>View</a> | <a href='edit_faculty.php?id=" . $row['faculty_id'] . "'>Edit</a> | <a href='delete_faculty.php?id=" . $row['faculty_id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No faculty members found.";
    }

    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>