<!DOCTYPE html>
<html>

<head>
    <title>College Management System</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .student-details {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .student-details h2 {
            text-align: center;
            margin-bottom: 20px;

        }

        .student-details p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .student-details img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .student-details .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .student-details .column {
            width: 48%;
        }

        @media only screen and (max-width: 768px) {
            .student-details .column {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/db_connect.php'; ?>

    <?php
    $admission_no = $_GET['id'];

    $sql = "SELECT * FROM Students WHERE admission_no=$admission_no";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='student-details'>";
        echo "<h2>Student Details</h2>";
        echo "<div class='row'>";
        echo "<div class='column'>";
        echo "<p><strong>First Name:</strong> " . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Last Name:</strong> " . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Birth:</strong> " . htmlspecialchars($row['dob'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Gender:</strong> " . htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Address:</strong> " . htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>County:</strong> " . htmlspecialchars($row['county'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Course Applied:</strong> " . htmlspecialchars($row['course_applied'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Nationality:</strong> " . htmlspecialchars($row['nationality'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "</div>";
        echo "<div class='column'>";
        echo "<p><strong>Parent/Guardian Name:</strong> " . htmlspecialchars($row['parent_name'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Parent/Guardian Phone:</strong> " . htmlspecialchars($row['parent_phone'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Relationship:</strong> " . htmlspecialchars($row['relationship'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Enrollment Date:</strong> " . htmlspecialchars($row['enrollment_date'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>Fees:</strong> KSh " . (isset($row['fees']) ? htmlspecialchars($row['fees'], ENT_QUOTES, 'UTF-8') : 'Not Available') . "</p>";
        echo "<p><strong>Picture:</strong></p><img src='data:image/jpeg;base64," . base64_encode($row['picture_upload']) . "' alt='Uploaded Picture'/>";
        echo "<p><strong>Certificate:</strong> <a href='data:application/pdf;base64," . base64_encode($row['certificate_upload']) . "' target='_blank'>View Certificate</a></p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div class='message error'>Student not found.</div>";
    }

    mysqli_close($conn);
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>