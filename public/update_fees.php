<?php
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['admission_no'])) {
    $admission_no = mysqli_real_escape_string($conn, $_GET['admission_no']);
    $admission_fee = mysqli_real_escape_string($conn, $_POST['admission_fee']);
    $tshirt_fee = mysqli_real_escape_string($conn, $_POST['tshirt_fee']);
    $workbook_fee = mysqli_real_escape_string($conn, $_POST['workbook_fee']);
    $apron_fee = mysqli_real_escape_string($conn, $_POST['apron_fee']);
    $activity_fee = mysqli_real_escape_string($conn, $_POST['activity_fee']);
    $caution_fee = mysqli_real_escape_string($conn, $_POST['caution_fee']);

    $sql = "UPDATE students SET admission_fee='$admission_fee', tshirt_fee='$tshirt_fee', workbook_fee='$workbook_fee', apron_fee='$apron_fee', activity_fee='$activity_fee', caution_fee='$caution_fee' WHERE admission_no='$admission_no'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Fees updated successfully!'); window.location.href = 'payments.php?admission_no=$admission_no';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); window.location.href = 'edit_fees.php?admission_no=$admission_no';</script>";
    }

    mysqli_close($conn);
}
?>