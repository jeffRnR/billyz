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
    $courses = mysqli_query($conn, "SELECT course_id, course_name, fees FROM courses");
    $students = mysqli_query($conn, "SELECT admission_no, first_name, last_name FROM students");
    ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process the form submission
        $admission_no = mysqli_real_escape_string($conn, $_POST['admission_no']);
        $amount_paid = mysqli_real_escape_string($conn, $_POST['amount_paid']);
        $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
        $payer_name = mysqli_real_escape_string($conn, $_POST['payer_name']);
        $payment_date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO payments (admission_no, amount_paid, payment_method, payer_name, payment_date) VALUES ('$admission_no', '$amount_paid', '$payment_method', '$payer_name', '$payment_date')";

        if (mysqli_query($conn, $sql)) {
            // Calculate fees balance
            $total_fees_query = mysqli_query($conn, "SELECT fees FROM students WHERE admission_no='$admission_no'");
            $total_fees = mysqli_fetch_assoc($total_fees_query)['fees'];

            $total_paid_query = mysqli_query($conn, "SELECT SUM(amount_paid) AS total_paid FROM payments WHERE admission_no='$admission_no'");
            $total_paid = mysqli_fetch_assoc($total_paid_query)['total_paid'];

            $balance = $total_fees - $total_paid;

            echo "<script>alert('Payment recorded successfully! Fees Balance: $balance');</script>";

            // Generate receipt
            echo "<h3>Receipt</h3>";
            echo "<p>Student Admission No: $admission_no</p>";
            echo "<p>Amount Paid: $amount_paid</p>";
            echo "<p>Payment Method: $payment_method</p>";
            echo "<p>Payer Name: $payer_name</p>";
            echo "<p>Payment Date: $payment_date</p>";
            echo "<p>Fees Balance: $balance</p>";

        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');</script>";
        }

        mysqli_close($conn);
    }
    ?>

    <button id="openFormButton">Add Payment</button>

    <div class="backdrop"></div>

    <div class="form-container">
        <h2>Add Payment</h2>
        <form action="add_payment.php" method="POST">
            <label for="admission_no">Student:</label>
            <select id="admission_no" name="admission_no" required>
                <?php while ($row = mysqli_fetch_assoc($students)) { ?>
                    <option value="<?php echo $row['admission_no']; ?>">
                        <?php echo $row['first_name'] . " " . $row['last_name']; ?>
                    </option>
                <?php } ?>
            </select>

            <label for="amount_paid">Amount Paid:</label>
            <input type="text" id="amount_paid" name="amount_paid" required>

            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="Mpesa">Mpesa</option>
                <option value="Cash">Cash</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>

            <label for="payer_name">Payer Name:</label>
            <input type="text" id="payer_name" name="payer_name" required>

            <button type="submit">Add Payment</button>
            <button type="button" id="closeFormButton">Close</button>
        </form>
    </div>

    <script src="../assets/js/popup.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>

</html>