<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php?error=Please login as admin first');
    exit();
}

if (!isset($_POST['action'])) {
    header('Location: admin.php?error=No action selected');
    exit();
}

$action = $_POST['action'];

// File upload handler
function handleImageUpload($files_key) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB
    $upload_dir = __DIR__ . '/Images/';
    
    // Create Images directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Check if file was uploaded
    if (!isset($_FILES[$files_key]) || $_FILES[$files_key]['error'] === UPLOAD_ERR_NO_FILE) {
        return null; // No file uploaded
    }
    
    $file = $_FILES[$files_key];
    
    // Validate file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false; // Error uploading file
    }
    
    if (!in_array($file['type'], $allowed_types)) {
        return false; // Invalid file type
    }
    
    if ($file['size'] > $max_size) {
        return false; // File too large
    }
    
    // Generate unique filename
    $filename = 'room_' . time() . '_' . basename($file['name']);
    $filepath = $upload_dir . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return 'Images/' . $filename;
    }
    
    return false; // Move failed
}

// ADD ROOM
if ($action == 'add_room') {
    $room_name = $_POST['room_name'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];
    
    // Handle image upload
    $image = handleImageUpload('image');
    if ($image === false) {
        header('Location: admin.php?error=Failed to upload image. Please use a valid image file (JPEG, PNG, GIF, WebP) under 5MB#rooms');
        exit();
    }
    
    // If no image uploaded, use empty string
    if ($image === null) {
        $image = '';
    }

    $sql = "INSERT INTO rooms (room_name, room_type, price, capacity, image, status)
            VALUES ('$room_name', '$room_type', '$price', '$capacity', '$image', '$status')";

    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php?msg=Room added successfully#rooms');
    } else {
        header('Location: admin.php?error=Failed to add room#rooms');
    }
    exit();
}

// UPDATE ROOM
if ($action == 'update_room') {
    $room_id = $_POST['room_id'];
    $room_name = $_POST['room_name'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];
    
    // Get existing image
    $existing_room = mysqli_query($conn, "SELECT image FROM rooms WHERE room_id='$room_id'");
    $existing_data = mysqli_fetch_assoc($existing_room);
    $image = $existing_data['image'];
    
    // Handle image upload if a new one was provided
    $upload_result = handleImageUpload('image');
    if ($upload_result === false) {
        header('Location: admin.php?error=Failed to upload image. Please use a valid image file (JPEG, PNG, GIF, WebP) under 5MB#rooms');
        exit();
    } elseif ($upload_result !== null) {
        $image = $upload_result; // Use new image if uploaded
    }

    $sql = "UPDATE rooms SET
            room_name='$room_name',
            room_type='$room_type',
            price='$price',
            capacity='$capacity',
            image='$image',
            status='$status'
            WHERE room_id='$room_id'";

    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php?msg=Room updated successfully#rooms');
    } else {
        header('Location: admin.php?error=Failed to update room#rooms');
    }
    exit();
}

// DELETE ROOM
if ($action == 'delete_room') {
    $room_id = $_POST['room_id'];

    $sql = "DELETE FROM rooms WHERE room_id='$room_id'";

    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php?msg=Room deleted successfully#rooms');
    } else {
        header('Location: admin.php?error=Failed to delete room#rooms');
    }
    exit();
}

// ADD MANUAL BOOKING (walk-in)
if ($action == 'add_booking_manual') {
    $guest_name = mysqli_real_escape_string($conn, $_POST['guest_name']);
    $guest_email = mysqli_real_escape_string($conn, $_POST['guest_email']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = $_POST['guests'];

    $room_q = mysqli_query($conn, "SELECT * FROM rooms WHERE room_type='$room_type' AND status='available' LIMIT 1");
    if (mysqli_num_rows($room_q) == 0) {
        header("Location: manage_bookings.php?error=No available $room_type rooms");
        exit();
    }
    $room = mysqli_fetch_assoc($room_q);
    $room_id = $room['room_id'];

    $nights = max(1, (strtotime($check_out) - strtotime($check_in)) / 86400);
    $total_amount = $room['price'] * $nights;

    $sql = "INSERT INTO bookings (room_id, room_name, guest_name, guest_email, check_in, check_out, guests, total_amount, booking_status, created_at)
            VALUES ('$room_id', '{$room['room_name']}', '$guest_name', '$guest_email', '$check_in', '$check_out', '$guests', '$total_amount', 'confirmed', NOW())";

    if (mysqli_query($conn, $sql)) {
        mysqli_query($conn, "UPDATE rooms SET status='booked' WHERE room_id='$room_id'");
        header('Location: manage_bookings.php?msg=Booking added successfully');
    } else {
        header('Location: manage_bookings.php?error=Failed to add booking');
    }
    exit();
}

// UPDATE BOOKING STATUS
if ($action == 'update_booking') {
    $booking_id = $_POST['booking_id'];
    $booking_status = $_POST['booking_status'];

    $sql = "UPDATE bookings SET booking_status='$booking_status' WHERE booking_id='$booking_id'";

    if (mysqli_query($conn, $sql)) {
        if ($booking_status == 'cancelled') {
            $bq = mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id='$booking_id'");
            $b = mysqli_fetch_assoc($bq);
            if (!empty($b['room_id'])) {
                mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_id='{$b['room_id']}'");
            } else {
                mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_name='{$b['room_name']}'");
            }
        }
        header('Location: manage_bookings.php?msg=Booking updated successfully');
    } else {
        header('Location: manage_bookings.php?error=Failed to update booking');
    }
    exit();
}

// DELETE BOOKING
if ($action == 'delete_booking') {
    $booking_id = $_POST['booking_id'];

    $bq = mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id='$booking_id'");
    $b = mysqli_fetch_assoc($bq);

    if (!empty($b['room_id'])) {
        mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_id='{$b['room_id']}'");
    } elseif (!empty($b['room_name'])) {
        mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_name='{$b['room_name']}'");
    }

    mysqli_query($conn, "DELETE FROM payments WHERE booking_id='$booking_id'");
    mysqli_query($conn, "DELETE FROM bookings WHERE booking_id='$booking_id'");

    header('Location: admin.php?msg=Booking and associated payments deleted#bookings');
    exit();
}

// DELETE CUSTOMER
if ($action == 'delete_customer') {
    $user_id = $_POST['user_id'];

    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM users WHERE user_id='$user_id'"));
    $email = $user['email'] ?? '';

    if ($email) {
        $bookings = mysqli_query($conn, "SELECT * FROM bookings WHERE guest_email='$email'");
        while ($b = mysqli_fetch_assoc($bookings)) {
            if (!empty($b['room_id'])) {
                mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_id='{$b['room_id']}'");
            } elseif (!empty($b['room_name'])) {
                mysqli_query($conn, "UPDATE rooms SET status='available' WHERE room_name='{$b['room_name']}'");
            }
            mysqli_query($conn, "DELETE FROM payments WHERE booking_id='{$b['booking_id']}'");
        }
        mysqli_query($conn, "DELETE FROM bookings WHERE guest_email='$email'");
    }

    mysqli_query($conn, "DELETE FROM users WHERE user_id='$user_id' AND role='guest'");

    header('Location: admin.php?msg=Customer and all their bookings deleted#customers');
    exit();
}

// CONFIRM PAYMENT (Snippe manual confirmation)
if ($action == 'confirm_payment') {
    $booking_id = $_POST['booking_id'];

    mysqli_query($conn, "UPDATE payments SET payment_status='completed' WHERE booking_id='$booking_id'");
    mysqli_query($conn, "UPDATE bookings SET booking_status='confirmed' WHERE booking_id='$booking_id'");

    $bq = mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id='$booking_id'");
    $b = mysqli_fetch_assoc($bq);
    if (!empty($b['room_id'])) {
        mysqli_query($conn, "UPDATE rooms SET status='booked' WHERE room_id='{$b['room_id']}'");
    } elseif (!empty($b['room_name'])) {
        mysqli_query($conn, "UPDATE rooms SET status='booked' WHERE room_name='{$b['room_name']}'");
    }

    header('Location: manage_bookings.php?msg=Payment confirmed and booking activated#bookings');
    exit();
}

header('Location: admin.php?error=Invalid action');
exit();
?>
