<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $guest_name = mysqli_real_escape_string($conn, $_POST['guest_name']);
    $guest_email = mysqli_real_escape_string($conn, $_POST['guest_email']);
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $price_per_night = mysqli_real_escape_string($conn, $_POST['price_per_night']);
    $check_in = mysqli_real_escape_string($conn, $_POST['check_in']);
    $check_out = mysqli_real_escape_string($conn, $_POST['check_out']);
    $guests = mysqli_real_escape_string($conn, $_POST['guests']);
    $room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;

    if ($check_out <= $check_in) {
        header('Location: room.php?error=Check-out must be after check-in');
        exit();
    }

    // Only allow booking if room is available
    if ($room_id > 0) {
        $check = mysqli_query($conn, "SELECT status FROM rooms WHERE room_id=$room_id");
        $r = mysqli_fetch_assoc($check);
        if (!$r || $r['status'] != 'available') {
            header('Location: room.php?error=Room is not available');
            exit();
        }
    }

    $sql = "INSERT INTO bookings 
            (guest_name, guest_email, room_name, price_per_night, check_in, check_out, guests, booking_status, room_id)
            VALUES 
            ('$guest_name', '$guest_email', '$room_name', '$price_per_night', '$check_in', '$check_out', '$guests', 'pending', $room_id)";

    if (mysqli_query($conn, $sql)) {
        $booking_id = mysqli_insert_id($conn);
        header('Location: payment.php?booking_id=' . $booking_id);
        exit();

    } else {
        echo "Database Error: " . mysqli_error($conn);
        exit();
    }
}
?>