<?php
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['admission_no'])) {
    $admission_no = mysqli_real_escape_string($conn, $_GET['admission_no']);
    $amount_paid = mysqli_real_escape_string($conn, $_POST['amount_paid']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $payer_name = mysqli_real_escape_string($conn, $_POST['payer_name']);
    $payment_date = date('Y-m-d H:i:s');
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);

    if ($payment_method != 'Cash' && empty($reference_number)) {
        echo "<script>alert('Reference number is required for Mpesa and Bank Transfer payments.'); window.location.href = 'payments.php?admission_no=$admission_no';</script>";
        exit();
    }

    $sql = "INSERT INTO payments (admission_no, amount_paid, payment_method, payer_name, payment_date, reference_number) VALUES ('$admission_no', '$amount_paid', '$payment_method', '$payer_name', '$payment_date', '$reference_number')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Payment recorded successfully!'); window.location.href = 'payments.php?admission_no=$admission_no';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); window.location.href = 'payments.php?admission_no=$admission_no';</script>";
    }

    mysqli_close($conn);
}
?>