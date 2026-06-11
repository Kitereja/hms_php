<?php
// Auto-checkin: if today >= check_in and status is 'confirmed', mark as checked_in
$checkin = mysqli_query($conn, "SELECT booking_id FROM bookings
                                WHERE booking_status='confirmed'
                                AND check_in <= CURDATE()");
while ($row = mysqli_fetch_assoc($checkin)) {
    mysqli_query($conn, "UPDATE bookings SET booking_status='checked_in' WHERE booking_id='{$row['booking_id']}'");
}

// Auto-checkout: if today > check_out and status is 'checked_in', mark as completed and free room
$checkout = mysqli_query($conn, "SELECT booking_id, room_id FROM bookings
                                 WHERE booking_status='checked_in'
                                 AND check_out < CURDATE()");
while ($row = mysqli_fetch_assoc($checkout)) {
    if (!empty($row['room_id'])) {
        mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_id='{$row['room_id']}'");
    }
    mysqli_query($conn, "UPDATE bookings SET booking_status='completed' WHERE booking_id='{$row['booking_id']}'");
}
