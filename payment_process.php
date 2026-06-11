<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $transaction_ref = mysqli_real_escape_string($conn, $_POST['transaction_ref']);

    // Save mock payment
    $sql = "INSERT INTO payments 
            (booking_id, amount, payment_method, transaction_ref, payment_status)
            VALUES 
            ('$booking_id', '$amount', '$payment_method', '$transaction_ref', 'completed')";

    if (mysqli_query($conn, $sql)) {

        mysqli_query($conn, "UPDATE bookings SET booking_status='confirmed' WHERE booking_id='$booking_id'");

        $bq = mysqli_query($conn, "SELECT room_id FROM bookings WHERE booking_id='$booking_id'");
        $b = mysqli_fetch_assoc($bq);
        if (!empty($b['room_id'])) {
            mysqli_query($conn, "UPDATE rooms SET status='booked' WHERE room_id='{$b['room_id']}'");
        }

        $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        if ($is_ajax) {
            echo json_encode(['success' => true, 'booking_id' => $booking_id]);
            exit();
        }
        header('Location: payment_success.php?booking_id=' . $booking_id);
        exit();

    } else {

        header('Location: payment.php?booking_id=' . $booking_id . '&error=Payment failed');
        exit();
    }
}
?>