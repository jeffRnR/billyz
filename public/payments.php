<!DOCTYPE html>
<html>

<head>
    <title>Student Payments</title>
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

        h2,
        h3 {
            text-align: center;
            color: #333;
        }

        .student-details {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .student-details img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .course-details {
            background-color: #e7f5ff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .form-container {
            margin-top: 20px;
        }

        .form-container form label {
            display: block;
            margin: 10px 0 5px;
        }

        .form-container form input,
        .form-container form select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .reference-number {
            display: none;
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
    <script>
        function toggleReferenceNumber(paymentMethod) {
            const referenceNumberField = document.querySelector('.reference-number');
            if (paymentMethod === 'Mpesa' || paymentMethod === 'Bank Transfer') {
                referenceNumberField.style.display = 'block';
                document.getElementById('reference_number').required = true;
            } else {
                referenceNumberField.style.display = 'none';
                document.getElementById('reference_number').required = false;
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <?php include '../includes/db_connect.php'; ?>

        <?php
        if (isset($_GET['admission_no'])) {
            $admission_no = $_GET['admission_no'];
            $student_query = mysqli_query($conn, "SELECT * FROM students WHERE admission_no='$admission_no'");
            $student = mysqli_fetch_assoc($student_query);

            $course_query = mysqli_query($conn, "SELECT course_name, fees FROM courses WHERE course_id='{$student['course_applied']}'");
            $course = mysqli_fetch_assoc($course_query);

            $payments_query = mysqli_query($conn, "SELECT * FROM payments WHERE admission_no='$admission_no' ORDER BY payment_date DESC");

            $total_fees = $course['fees'];
            $total_paid = 0;
            while ($payment = mysqli_fetch_assoc($payments_query)) {
                $total_paid += $payment['amount_paid'];
            }
            $balance = $total_fees - $total_paid;
            ?>

            <div class="student-details">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($student['student_image']); ?>"
                    alt="Student Image">
                <div>
                    <h2>Payment Record For <?php echo $student['first_name'] . " " . $student['last_name']; ?></h2>
                    <h3>Admission No: <?php echo $student['admission_no']; ?></h3>
                </div>
            </div>

            <div class="course-details">
                <h3>Course: <?php echo $course['course_name']; ?></h3>
                <h3>Total Fees: <?php echo $total_fees; ?></h3>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Amount Paid</th>
                        <th>Payment Method</th>
                        <th>Payer Name</th>
                        <th>Payment Date</th>
                        <th>Reference Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($payments_query, 0); // Reset query result pointer
                    while ($payment = mysqli_fetch_assoc($payments_query)) { ?>
                        <tr>
                            <td><?php echo $payment['payment_id']; ?></td>
                            <td><?php echo $payment['amount_paid']; ?></td>
                            <td><?php echo $payment['payment_method']; ?></td>
                            <td><?php echo $payment['payer_name']; ?></td>
                            <td><?php echo $payment['payment_date']; ?></td>
                            <td><?php echo !empty($payment['reference_number']) ? $payment['reference_number'] : "N/A"; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <h3>Balance: <?php echo $balance >= 0 ? $balance : "Overpaid by " . abs($balance); ?></h3>

            <div class="form-container">
                <h2>Update Payment for <?php echo $student['first_name'] . " " . $student['last_name']; ?></h2>

                <form action="add_payments.php?admission_no=<?php echo $admission_no; ?>" method="POST">
                    <label for="amount_paid">Amount Paid:</label>
                    <input type="text" id="amount_paid" name="amount_paid" required>

                    <label for="payment_method">Payment Method:</label>
                    <select id="payment_method" name="payment_method" onchange="toggleReferenceNumber(this.value)" required>
                        <option value="Mpesa">Mpesa</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>

                    <div class="reference-number" style="display: none;">
                        <label for="reference_number">Reference Number:</label>
                        <input type="text" id="reference_number" name="reference_number">
                    </div>

                    <label for="payer_name">Payer Name:</label>
                    <input type="text" id="payer_name" name="payer_name" required>

                    <button type="submit" class="button">Update Payment</button>
                </form>
            </div>

            <div class="form-container">
                <h2>Print Statement</h2>
                <button type="button" class="button" onclick="window.print();">Print Statement</button>
            </div>

        <?php } else { ?>
            <p>No student selected. Please go back and select a student.</p>
        <?php } ?>
    </div>

    <?php mysqli_close($conn); ?>
</body>

</html>