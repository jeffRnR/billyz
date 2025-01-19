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
    $admission_no = $_GET['id'];
    $sql = "SELECT * FROM Students WHERE admission_no=$admission_no";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $county = $_POST['county'];
        $course_applied = $_POST['course_applied'];
        $nationality = $_POST['nationality'];
        $parent_name = $_POST['parent_name'];
        $parent_phone = $_POST['parent_phone'];
        $relationship = $_POST['relationship'];
        $enrollment_date = $_POST['enrollment_date'];

        // Handling file upload
        if ($_FILES['student_image']['tmp_name']) {
            $student_image = addslashes(file_get_contents($_FILES['student_image']['tmp_name']));
            $image_query = ", student_image='$student_image'";
        } else {
            $image_query = "";
        }

        $sql = "UPDATE Students SET 
                first_name='$first_name', 
                last_name='$last_name', 
                dob='$dob', 
                gender='$gender', 
                address='$address', 
                phone='$phone', 
                county='$county', 
                course_applied='$course_applied', 
                nationality='$nationality', 
                parent_name='$parent_name', 
                parent_phone='$parent_phone', 
                relationship='$relationship', 
                enrollment_date='$enrollment_date' 
                $image_query 
                WHERE admission_no=$admission_no";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='message success'>Student information updated successfully!</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        mysqli_close($conn);
    } else {
        ?>
        <div class="form-container">
            <h2>Update Student Information</h2>
            <form action="update_student.php?id=<?php echo $student['admission_no']; ?>" method="POST"
                enctype="multipart/form-data">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name"
                    value="<?php echo htmlspecialchars($student['first_name'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name"
                    value="<?php echo htmlspecialchars($student['last_name'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob"
                    value="<?php echo htmlspecialchars($student['dob'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male" <?php if ($student['gender'] == 'Male')
                        echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($student['gender'] == 'Female')
                        echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($student['gender'] == 'Other')
                        echo 'selected'; ?>>Other</option>
                </select>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address"
                    value="<?php echo htmlspecialchars($student['address'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone"
                    value="<?php echo htmlspecialchars($student['phone'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="county">County:</label>
                <select id="county" name="county" required>
                    <option value="Nairobi" <?php if ($student['county'] == 'Nairobi')
                        echo 'selected'; ?>>Nairobi</option>
                    <option value="Mombasa" <?php if ($student['county'] == 'Mombasa')
                        echo 'selected'; ?>>Mombasa</option>
                    <!-- Add more counties here -->
                </select>

                <label for="course_applied">Course Applied:</label>
                <input type="text" id="course_applied" name="course_applied"
                    value="<?php echo htmlspecialchars($student['course_applied'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="nationality">Nationality:</label>
                <select id="nationality" name="nationality" required>
                    <option value="Kenya" <?php if ($student['nationality'] == 'Kenya')
                        echo 'selected'; ?>>Kenya</option>
                    <option value="Uganda" <?php if ($student['nationality'] == 'Uganda')
                        echo 'selected'; ?>>Uganda</option>
                    <!-- Add more countries here -->
                </select>

                <label for="parent_name">Parent/Guardian Name:</label>
                <input type="text" id="parent_name" name="parent_name"
                    value="<?php echo htmlspecialchars($student['parent_name'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="parent_phone">Parent/Guardian Phone:</label>
                <input type="text" id="parent_phone" name="parent_phone"
                    value="<?php echo htmlspecialchars($student['parent_phone'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="relationship">Relationship:</label>
                <input type="text" id="relationship" name="relationship"
                    value="<?php echo htmlspecialchars($student['relationship'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="student_image">Upload Student ID:</label>
                <input type="file" id="student_image" name="student_image" accept="image/*">

                <label for="enrollment_date">Enrollment Date:</label>
                <input type="date" id="enrollment_date" name="enrollment_date"
                    value="<?php echo htmlspecialchars($student['enrollment_date'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <button type="submit">Update Student</button>
            </form>
        </div>
        <?php
    }
    ?>

    <?php include '../includes/footer.php'; ?>
</body>

</html>