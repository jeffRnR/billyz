<?php
// Suppress error reporting
error_reporting(0);

// Start the session at the very beginning of the file
@session_start();

// Include the database connection
include '../includes/db_connect.php';

// Initialize variables
$department_code = '';
$success_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['departmentFormSubmitted'])) {
    // Retrieve form data
    $department_name = $_POST['department_name'];
    $department_description = $_POST['department_description'];

    // Check if any of the fields are empty
    if (empty($department_name) || empty($department_description)) {
        $success_message = "<div class='error'>All fields are required! Please fill out all the information.</div>";
    } else {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO departments (department_name, department_description) VALUES (?, ?)");
        $stmt->bind_param("ss", $department_name, $department_description);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the last inserted ID to generate the department code
            $last_id = $stmt->insert_id;
            $department_code = 'BLC' . str_pad($last_id, 4, '0', STR_PAD_LEFT);

            // Update the department with the generated code
            $stmt_update = $conn->prepare("UPDATE departments SET department_code = ? WHERE department_id = ?");
            $stmt_update->bind_param("si", $department_code, $last_id);
            $stmt_update->execute();

            // Set success message
            $success_message = "<div class='success-popup' id='successPopup'>
                                    <div class='popup-content'>
                                        <span class='check-icon'>&#10003;</span>
                                        Department added successfully! Department Code: $department_code
                                    </div>
                                </div>";

            // Redirect to prevent resubmission
            header("Location: add_department.php?success_message=" . urlencode($success_message));
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
    <title>Add Department</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Include your CSS file -->
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
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 16px;
            color: #555;
            text-align: left;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            width: 100%;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button[type="submit"] {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Success and error messages */
        .success {
            color: #4CAF50;
            font-size: 16px;
            padding: 10px;
            background-color: #e8f5e9;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .error {
            color: #f44336;
            font-size: 16px;
            padding: 10px;
            background-color: #ffebee;
            border: 1px solid #f44336;
            border-radius: 5px;
            margin-bottom: 20px;
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        }

        /* Header and Footer styles (for example purposes) */
        header,
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        header a,
        footer a {
            color: #fff;
            text-decoration: none;
        }

        footer {
            margin-top: 40px;
        }
    </style>
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
        <h2>Add New Department</h2>
        <form action="add_department.php" method="POST">
            <label for="department_name">Department Name:</label>
            <input type="text" id="department_name" name="department_name" required>

            <label for="department_description">Department Description:</label>
            <textarea id="department_description" name="department_description" required></textarea>

            <input type="hidden" name="departmentFormSubmitted" value="1">
            <button type="submit">Add Department</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?> <!-- Include footer -->

    <!-- Display success message if any -->
    <?php echo $success_message; ?>
</body>

</html>