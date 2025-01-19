<!DOCTYPE html>
<html>

<head>
    <title>Edit Additional Fees</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: block;
            margin: 10px auto;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include '../includes/db_connect.php'; ?>

        <?php
        if (isset($_GET['admission_no'])) {
            $admission_no = $_GET['admission_no'];
            $student_query = mysqli_query($conn, "SELECT * FROM students WHERE admission_no='$admission_no'");
            $student = mysqli_fetch_assoc($student_query);
            ?>

            <h2>Edit Additional Fees for <?php echo $student['first_name'] . " " . $student['last_name']; ?></h2>

            <form action="update_fees.php?admission_no=<?php echo $admission_no; ?>" method="POST">
                <label for="admission_fee">Admission Fee:</label>
                <input type="text" id="admission_fee" name="admission_fee" value="<?php echo $student['admission_fee']; ?>"
                    required>

                <label for="tshirt_fee">School T-Shirt:</label>
                <input type="text" id="tshirt_fee" name="tshirt_fee" value="<?php echo $student['tshirt_fee']; ?>" required>

                <label for="workbook_fee">Workbook:</label>
                <input type="text" id="workbook_fee" name="workbook_fee" value="<?php echo $student['workbook_fee']; ?>"
                    required>

                <label for="apron_fee">Apron:</label>
                <input type="text" id="apron_fee" name="apron_fee" value="<?php echo $student['apron_fee']; ?>" required>

                <label for="activity_fee">Activity Fee:</label>
                <input type="text" id="activity_fee" name="activity_fee" value="<?php echo $student['activity_fee']; ?>"
                    required>

                <label for="caution_fee">Caution Fee:</label>
                <input type="text" id="caution_fee" name="caution_fee" value="<?php echo $student['caution_fee']; ?>"
                    required>

                <button type="submit" class="button">Update Fees</button>
            </form>

        <?php } else { ?>
            <p>No student selected. Please go back and select a student.</p>
        <?php } ?>

        <?php mysqli_close($conn); ?>
    </div>
</body>

</html>