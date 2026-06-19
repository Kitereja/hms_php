<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $transaction_ref = mysqli_real_escape_string($conn, $_POST['transaction_ref']);

    $sql = "INSERT INTO payments 
            (booking_id, amount, payment_method, transaction_ref, payment_status)
            VALUES 
            ('$booking_id', '$amount', '$payment_method', '$transaction_ref', 'pending')";

    if (mysqli_query($conn, $sql)) {

        mysqli_query($conn, "UPDATE bookings SET booking_status='pending' WHERE booking_id='$booking_id'");

        header('Location: payment.php?booking_id=' . $booking_id . '&success=1');
        exit();

    } else {

        header('Location: payment.php?booking_id=' . $booking_id . '&error=Payment failed');
        exit();
    }
}
?>