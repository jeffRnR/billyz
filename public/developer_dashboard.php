<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

function is_developer($role_id)
{
    return $role_id == 6; // Assuming 6 is Developer
}

if (!isset($_SESSION['role_id']) || !is_developer($_SESSION['role_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch statistics from the database
$query_students = "SELECT COUNT(*) AS total_students FROM students";
$result_students = mysqli_query($conn, $query_students);
$row_students = mysqli_fetch_assoc($result_students);
$number_of_students = $row_students['total_students'];

// Assuming 'role_id' for staff is known, for example 2
$role_id_staff = 2;
$query_staff = "SELECT COUNT(*) AS total_staff FROM users WHERE role_id = $role_id_staff";
$result_staff = mysqli_query($conn, $query_staff);
$row_staff = mysqli_fetch_assoc($result_staff);
$number_of_staff = $row_staff['total_staff'];

$add_staff = "Add Staff";
$add_student = "Add Student";
$courses = 100; // Placeholder for course count
$announcements = 5; // Placeholder for announcement count
$recent_payments = 20000; // Example recent payments
$mark_attendance = "Mark Attendance"; // New variable for Mark Attendance
$payroll = 250000; // Example payroll
$timetable = "View Timetable"; // Placeholder for timetable link
$add_new_course = "Add New Course"; // New variable for Add New Course
$update_grades = "Update Grades"; // New variable for Update Grades
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .form-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1001;
            width: 400px;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="content-fullscreen">
        <div class="dashboard-cards">
            <div class="card">
                <a href="list_students.php" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Students</h3>
                    <p><?php echo $number_of_students; ?></p>
                </a>
            </div>

            <div class="card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>Staff</h3>
                <p><?php echo $number_of_staff; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-user-plus"></i>
                <h3>New Staff</h3>
                <p><?php echo $add_staff; ?></p>
            </div>
            <div class="card" id="openStudentFormButton">
                <i class="fas fa-user-plus"></i>
                <h3>New Student</h3>
                <p><?php echo $add_student; ?></p>
            </div>
            <div class="card" id="openCourseFormButton">
                <i class="fas fa-plus-circle"></i>
                <h3>Add New Course</h3>
                <p><?php echo $add_new_course; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-edit"></i>
                <h3>Update Grades</h3>
                <p><?php echo $update_grades; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Receive Payment</h3>
                <p><?php echo $recent_payments; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3>Mark Attendance</h3>
                <p><?php echo $mark_attendance; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-file-invoice-dollar"></i>
                <h3>Payroll</h3>
                <p><?php echo $payroll; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-calendar-alt"></i>
                <h3>Timetable</h3>
                <p><?php echo $timetable; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-book"></i>
                <h3>Courses</h3>
                <p><?php echo $courses; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-bullhorn"></i>
                <h3>Announcements</h3>
                <p><?php echo $announcements; ?></p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <div class="success-message" id="successMessage">Data successfully added!</div>

    <!-- Popup form for adding a new student -->
    <div class="backdrop" id="backdrop"></div>

    <!-- Add New Student Form -->
    <div class="form-container" id="studentForm">
        <h2>Add New Student</h2>
        <form id="studentFormAction" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="county">County:</label>
            <select id="county" name="county" required>
                <option value="Nairobi">Nairobi</option>
                <option value="Mombasa">Mombasa</option>
            </select>

            <label for="course_applied">Course Applied:</label>
            <input type="text" id="course_applied" name="course_applied" required>

            <label for="nationality">Nationality:</label>
            <select id="nationality" name="nationality" required>
                <option value="Kenya">Kenya</option>
                <option value="Uganda">Uganda</option>
            </select>

            <label for="parent_name">Parent/Guardian Name:</label>
            <input type="text" id="parent_name" name="parent_name" required>

            <label for="parent_phone">Parent/Guardian Phone:</label>
            <input type="text" id="parent_phone" name="parent_phone" required>

            <label for="relationship">Relationship:</label>
            <input type="text" id="relationship" name="relationship" required>

            <label for="student_image">Upload Student ID:</label>
            <input type="file" id="student_image" name="student_image" accept="image/*" required>

            <label for="picture_upload">Upload Picture:</label>
            <input type="file" id="picture_upload" name="picture_upload" accept="image/*" required>

            <label for="certificate_upload">Upload Certificate (PDF):</label>
            <input type="file" id="certificate_upload" name="certificate_upload" accept="application/pdf" required>

            <label for="enrollment_date">Enrollment Date:</label>
            <input type="date" id="enrollment_date" name="enrollment_date" required>

            <button type="submit">Add Student</button>
            <button type="button" id="closeStudentFormButton">Close</button>
        </form>
    </div>

    <!-- Add New Course Form -->
    <div class="form-container" id="courseForm">
        <h2>Add New Course</h2>
        <form id="courseFormAction" method="POST">
            <label for="course_name">Course Name:</label>
            <input type="text" id="course_name" name="course_name" required>

            <label for="course_description">Course Description:</label>
            <textarea id="course_description" name="course_description" required></textarea>

            <label for="credits">Credits:</label>
            <input type="number" id="credits" name="credits" required>

            <label for="fees">Fees:</label>
            <input type="number" id="fees" name="fees" required>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <button type="submit">Add Course</button>
            <button type="button" id="closeCourseFormButton">Close</button>
        </form>
    </div>

    <script>
        // Open the Add New Student form
        document.getElementById("openStudentFormButton").onclick = function () {
            document.getElementById("backdrop").style.display = "block";
            document.getElementById("studentForm").style.display = "block";
        };

        // Open the Add New Course form
        document.getElementById("openCourseFormButton").onclick = function () {
            document.getElementById("backdrop").style.display = "block";
            document.getElementById("courseForm").style.display = "block";
        };

        // Close the Add New Student form
        document.getElementById("closeStudentFormButton").onclick = function () {
            document.getElementById("backdrop").style.display = "none";
            document.getElementById("studentForm").style.display = "none";
        };

        // Close the Add New Course form
        document.getElementById("closeCourseFormButton").onclick = function () {
            document.getElementById("backdrop").style.display = "none";
            document.getElementById("courseForm").style.display = "none";
        };

        // Handle course form submission
        document.getElementById("courseFormAction").onsubmit = function (e) {
            e.preventDefault(); // Prevent form from reloading the page
            var formData = new FormData(this);

            fetch('add_course.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("successMessage").style.display = 'block';
                    setTimeout(function () {
                        document.getElementById("successMessage").style.display = 'none';
                    }, 5000);
                    document.getElementById("courseForm").style.display = 'none';
                    document.getElementById("backdrop").style.display = 'none';
                })
                .catch(error => console.error('Error:', error));
        };

        // Handle student form submission
        document.getElementById("studentFormAction").onsubmit = function (e) {
            e.preventDefault(); // Prevent form from reloading the page
            var formData = new FormData(this);

            fetch('add_student.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("successMessage").style.display = 'block';
                    setTimeout(function () {
                        document.getElementById("successMessage").style.display = 'none';
                    }, 5000);
                    document.getElementById("studentForm").style.display = 'none';
                    document.getElementById("backdrop").style.display = 'none';
                })
                .catch(error => console.error('Error:', error));
        };
    </script>

    <script src="../assets/js/popup.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>

</html>