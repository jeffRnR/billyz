<?php include '../includes/header.php'; ?>
<?php include '../includes/db_connect.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>College Management System</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <style>
        #search-bar {
            width: 50%;
            padding: 5px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        #search-results {
            margin-top: 20px;
        }

        .search-results-table {
            width: 100%;
            border-collapse: collapse;
        }

        .search-results-table th,
        .search-results-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .search-results-table th {
            background-color: #f2f2f2;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }

        /* Style for buttons */
        .button-link {
            display: inline-block;
            padding: 8px 16px;
            margin: 4px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
        }

        .button-link:hover {
            background-color: #45a049;
        }

        .button-link:active {
            background-color: #3e8e41;
        }

        .button-link.update {
            background-color: #ffa500;
        }

        .button-link.update:hover {
            background-color: #e68a00;
        }

        .button-link.update:active {
            background-color: #cc7a00;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        .backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#search-bar").on("keyup", function () {
                var searchValue = $(this).val();
                if (searchValue.length > 2) {
                    $.ajax({
                        url: "search_students.php",
                        type: "GET",
                        data: { search: searchValue },
                        success: function (response) {
                            $("#search-results").html(response);
                        }
                    });
                } else {
                    $("#search-results").html("");
                }
            });
        });
    </script>
</head>

<body>

    <div class="container">
        <?php include '../includes/db_connect.php'; ?>

        <h2>Student List</h2>
        <input type="text" id="search-bar" placeholder="Search by Admission No or Name">
        <div id="search-results"></div>

        <?php
        $students = mysqli_query($conn, "SELECT * FROM students");

        echo "<table class='search-results-table'>";
        echo "<tr><th>Admission No</th><th>First Name</th><th>Last Name</th><th>Details</th><th>Update</th></tr>";

        while ($row = mysqli_fetch_assoc($students)) {
            echo "<tr>";
            echo "<td>" . $row['admission_no'] . "</td>";
            echo "<td>" . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td><a href='payments.php?admission_no=" . $row['admission_no'] . "' class='button-link'>View/Add Payments</a></td>";
            echo "<td><a href='update_student.php?id=" . $row['admission_no'] . "' class='button-link update'>Update</a></td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>

        <?php
        if (isset($_GET['admission_no'])) {
            $admission_no = $_GET['admission_no'];
            $student_query = mysqli_query($conn, "SELECT * FROM students WHERE admission_no='$admission_no'");
            $student = mysqli_fetch_assoc($student_query);

            $payments_query = mysqli_query($conn, "SELECT * FROM payments WHERE admission_no='$admission_no' ORDER BY payment_date DESC");
            ?>

            <div class="form-container">
                <h2>Payment Records for <?php echo $student['first_name'] . " " . $student['last_name']; ?></h2>

                <table>
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Amount Paid</th>
                            <th>Payment Method</th>
                            <th>Payer Name</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($payment = mysqli_fetch_assoc($payments_query)) { ?>
                            <tr>
                                <td><?php echo $payment['payment_id']; ?></td>
                                <td><?php echo $payment['amount_paid']; ?></td>
                                <td><?php echo $payment['payment_method']; ?></td>
                                <td><?php echo $payment['payer_name']; ?></td>
                                <td><?php echo $payment['payment_date']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="form-container">
                <h2>Update Payment for <?php echo $student['first_name'] . " " . $student['last_name']; ?></h2>

                <form action="add_payments.php?admission_no=<?php echo $admission_no; ?>" method="POST">
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

                    <button type="submit" class="button">Update Payment</button>
                    <button type="button" onclick="window.history.back()" class="button">Cancel</button>
                </form>
            </div>

        <?php } ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>