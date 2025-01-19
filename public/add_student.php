<?php
// Include the database connection
include '../includes/db_connect.php';

// Initialize variables
$success_message = '';
$courses = [];

// Fetch courses for the dropdown
$result = $conn->query("SELECT course_id, course_name, fees FROM courses");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['studentFormSubmitted'])) {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $county = $_POST['county'];
    $course_id = $_POST['course_id'];
    $nationality = $_POST['nationality'];
    $parent_name = $_POST['parent_name'];
    $parent_phone = $_POST['parent_phone'];
    $relationship = $_POST['relationship'];
    $enrollment_date = $_POST['enrollment_date'];

    // Upload image and files
    $student_image = addslashes(file_get_contents($_FILES['student_image']['tmp_name']));
    $picture_upload = addslashes(file_get_contents($_FILES['picture_upload']['tmp_name']));
    $certificate_upload = addslashes(file_get_contents($_FILES['certificate_upload']['tmp_name']));

    // Fetch the course fee from the courses table based on the selected course
    $stmt = $conn->prepare("SELECT fees FROM courses WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $stmt->bind_result($fees);
    $stmt->fetch();
    $stmt->close();

    // Check if any of the fields are empty
    if (empty($first_name) || empty($last_name) || empty($dob) || empty($gender) || empty($address) || empty($phone) || empty($county) || empty($course_id) || empty($nationality) || empty($parent_name) || empty($parent_phone) || empty($relationship) || empty($enrollment_date)) {
        $success_message = "<div class='error'>All fields are required! Please fill out all the information.</div>";
    } else {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, dob, gender, address, phone, county, course_applied, nationality, parent_name, parent_phone, relationship, student_image, picture_upload, certificate_upload, fees, enrollment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssdsd", $first_name, $last_name, $dob, $gender, $address, $phone, $county, $course_id, $nationality, $parent_name, $parent_phone, $relationship, $student_image, $picture_upload, $certificate_upload, $fees, $enrollment_date);

        // Execute the statement
        if ($stmt->execute()) {
            // Set success message
            $success_message = "<div class='success-popup' id='successPopup'>
                                    <div class='popup-content'>
                                        <span class='check-icon'>&#10003;</span>
                                        Student added successfully!
                                    </div>
                                </div>";

            // Redirect to prevent resubmission
            header("Location: add_student.php?success_message=" . urlencode($success_message));
            exit;  // Always call exit after a redirect to stop further execution of the script
        } else {
            $success_message = "<div class='error'>Error: " . $stmt->error . "</div>";
        }

        // Close the statement and the database connection
        $stmt->close();
        mysqli_close($conn);
    }
}

// Display success message if set
if (isset($_GET['success_message'])) {
    $success_message = $_GET['success_message'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Include your CSS file -->
    <link rel="stylesheet" href="../assets/css/add_student.css"> <!-- Include the new CSS file -->
    <script>
        // Show the success pop-up if it exists
        window.onload = function () {
            var successPopup = document.getElementById('successPopup');
            if (successPopup) {
                successPopup.style.display = 'block';
                setTimeout(function () {
                    successPopup.style.display = 'none';
                }, 5000); // Hide after 5 seconds
            }
        }
    </script>
</head>

<body>
    <?php include '../includes/header.php'; ?> <!-- Include header -->

    <div class="container">
        <h2>Add New Student</h2>
        <form action="add_student.php" method="POST" enctype="multipart/form-data">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="county">County:</label>
            <input type="text" id="county" name="county" required>

            <label for="course_id">Course Applied:</label>
            <select id="course_id" name="course_id" required>
                <option value="">Select Course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="nationality">Nationality:</label>
            <input type="text" id="nationality" name="nationality" required>

            <label for="parent_name">Parent/Guardian Name:</label>
            <input type="text" id="parent_name" name="parent_name" required>

            <label for="parent_phone">Parent/Guardian Phone:</label>
            <input type="text" id="parent_phone" name="parent_phone" required>

            <label for="relationship">Relationship to Student:</label>
            <input type="text" id="relationship" name="relationship" required>

            <label for="student_image">Student Image:</label>
            <input type="file" id="student_image" name="student_image" required>

            <label for="picture_upload">Picture Upload:</label>
            <input type="file" id="picture_upload" name="picture_upload" required>

            <label for="certificate_upload">Certificate Upload:</label>
            <input type="file" id="certificate_upload" name="certificate_upload" required>

            <label for="enrollment_date">Enrollment Date:</label>
            <input type="date" id="enrollment_date" name="enrollment_date" required>

            <input type="hidden" name="studentFormSubmitted" value="1">
            <button type="submit">Add Student</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?> <!-- Include footer -->

    <!-- Display success message if any -->
    <?php echo $success_message; ?>
</body>

</html>