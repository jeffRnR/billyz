<?php
// Include the database connection
include '../includes/db_connect.php';

// Initialize variables
$success_message = '';

// Fetch departments for the dropdown
$departments = [];
$result = $conn->query("SELECT department_id, department_name FROM departments");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['courseFormSubmitted'])) {
    // Retrieve form data
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];
    $course_duration = $_POST['course_duration'];
    $credits = $_POST['credits'];
    $fees = $_POST['fees'];
    $extra_charges = $_POST['extra_charges'];
    $reason_for_extra_fee = $_POST['reason_for_extra_fee'];
    $department_id = $_POST['department_id'];

    // Check if any of the fields are empty
    if (empty($course_name) || empty($course_description) || empty($course_duration) || empty($credits) || empty($fees) || empty($extra_charges) || empty($reason_for_extra_fee) || empty($department_id)) {
        $success_message = "<div class='error'>All fields are required! Please fill out all the information.</div>";
    } else {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO courses (course_name, course_description, course_duration, credits, fees, extra_charges, reason_for_extra_fee, department_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siidisdi", $course_name, $course_description, $course_duration, $credits, $fees, $extra_charges, $reason_for_extra_fee, $department_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Set success message
            $success_message = "<div class='success-popup' id='successPopup'>
                                    <div class='popup-content'>
                                        <span class='check-icon'>&#10003;</span>
                                        Course added successfully!
                                    </div>
                                </div>";

            // Redirect to prevent resubmission
            header("Location: add_course.php?success_message=" . urlencode($success_message));
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
    <title>Add Course</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Include your CSS file -->
    <link rel="stylesheet" href="../assets/css/add_course.css"> <!-- Include the new CSS file -->
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
<style>
    /* General styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        max-width: 500px;
        /* Decrease max-width for a smaller container */
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        /* Enhance shadow for a modern look */
        text-align: center;
    }

    h2 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
        font-weight: bold;
    }

    /* Form styles */
    form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        /* Reduce gap between fields */
        justify-content: space-between;
    }

    label {
        font-size: 16px;
        color: #555;
        text-align: left;
        margin-bottom: 5px;
        flex-basis: 100%;
    }

    input[type="text"],
    textarea,
    input[type="number"],
    input[type="decimal"],
    select {
        padding: 8px;
        /* Reduce padding for smaller input fields */
        font-size: 14px;
        /* Slightly smaller font size */
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
        width: calc(48% - 5px);
        /* Adjust width for better alignment */
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
        /* Smaller minimum height */
        width: 100%;
        /* Make the textarea full width */
    }

    button[type="submit"] {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        width: calc(50% - 5px);
        /* Adjust width for better alignment */
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    /* Success and error messages */
    /* General styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        max-width: 500px;
        /* Decrease max-width for a smaller container */
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        /* Enhance shadow for a modern look */
        text-align: center;
    }

    h2 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
        font-weight: bold;
    }

    /* Form styles */
    form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        /* Reduce gap between fields */
        justify-content: space-between;
    }

    label {
        font-size: 16px;
        color: #555;
        text-align: left;
        margin-bottom: 5px;
        flex-basis: 100%;
    }

    input[type="text"],
    textarea,
    input[type="number"],
    input[type="decimal"],
    select {
        padding: 8px;
        /* Reduce padding for smaller input fields */
        font-size: 14px;
        /* Slightly smaller font size */
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
        width: calc(48% - 5px);
        /* Adjust width for better alignment */
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
        /* Smaller minimum height */
        width: 100%;
        /* Make the textarea full width */
    }

    button[type="submit"] {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        width: calc(50% - 5px);
        /* Adjust width for better alignment */
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    /* Success and error messages */
    .success {
        color: #4CAF50;
        font-size: 14px;
        /* Slightly smaller font size */
        padding: 10px;
        background-color: #e8f5e9;
        border: 1px solid #4CAF50;
        border-radius: 5px;
        margin-bottom: 10px;
        /* Reduce margin */
    }

    .error {
        color: #f44336;
        font-size: 14px;
        /* Slightly smaller font size */
        padding: 10px;
        background-color: #ffebee;
        border: 1px solid #f44336;
        border-radius: 5px;
        margin-bottom: 10px;
        /* Reduce margin */
    }

    /* Popup styles */
    .success-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #4CAF50;
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        /* Enhance shadow for a modern look */
        padding: 20px;
        text-align: center;
        z-index: 1000;
        display: none;
    }

    .popup-content {
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .check-icon {
        font-size: 24px;
        color: white;
    }
</style>

<body>
    <?php include '../includes/header.php'; ?> <!-- Include header -->

    <div class="container">
        <h2>Add New Course</h2>
        <form action="add_course.php" method="POST">
            <label for="course_name">Course Name:</label>
            <input type="text" id="course_name" name="course_name" required>

            <label for="course_description">Course Description:</label>
            <textarea id="course_description" name="course_description" required></textarea>

            <label for="course_duration">Course Duration (in months):</label>
            <input type="number" id="course_duration" name="course_duration" required>

            <label for="credits">Credits:</label>
            <input type="number" id="credits" name="credits" required>

            <label for="fees">Fees:</label>
            <input type="decimal" id="fees" name="fees" required>

            <label for="extra_charges">Extra Charges:</label>
            <input type="decimal" id="extra_charges" name="extra_charges" required>

            <label for="reason_for_extra_fee">Reason for Extra Fee:</label>
            <input type="text" id="reason_for_extra_fee" name="reason_for_extra_fee" maxlength="15" required>

            <label for="department_id">Department:</label>
            <select id="department_id" name="department_id" required>
                <option value="">Select Department</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?php echo $department['department_id']; ?>">
                        <?php echo $department['department_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="hidden" name="courseFormSubmitted" value="1">
            <button type="submit">Add Course</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?> <!-- Include footer -->

    <!-- Display success message if any -->
    <?php echo $success_message; ?>
</body>

</html>