<?php
include 'admin_layout.php';

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
$bookings = mysqli_query($conn, "SELECT * FROM bookings ORDER BY booking_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>

    <main class="main-content">
        <div class="page-title">
            <h1>Bookings</h1>
            <p>Manage all reservations</p>
        </div>

        <?php if ($msg) echo "<p class='success'>$msg</p>"; ?>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>

        

        <div class="panel">
            <table>
                <tr><th>ID</th><th>Guest</th><th>Email</th><th>Room</th><th>Check In</th><th>Check Out</th><th>Status</th><th>Action</th></tr>
                <?php while($booking = mysqli_fetch_assoc($bookings)) { ?>
                <tr>
                    <form action="admin_process.php" method="POST">
                        <td><?php echo $booking['booking_id']; ?><input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>"></td>
                        <td><?php echo $booking['guest_name']; ?></td>
                        <td><?php echo $booking['guest_email']; ?></td>
                        <td><?php echo $booking['room_name']; ?></td>
                        <td><?php echo $booking['check_in']; ?></td>
                        <td><?php echo $booking['check_out']; ?></td>
                        <td>
                            <select name="booking_status">
                                <option value="confirmed" <?php if($booking['booking_status']=='confirmed') echo 'selected'; ?>>Confirmed</option>
                                <option value="checked_in" <?php if($booking['booking_status']=='checked_in') echo 'selected'; ?>>Checked In</option>
                                <option value="completed" <?php if($booking['booking_status']=='completed') echo 'selected'; ?>>Completed</option>
                                <option value="cancelled" <?php if($booking['booking_status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                                <option value="payment_failed" <?php if($booking['booking_status']=='payment_failed') echo 'selected'; ?>>Payment Failed</option>
                            </select>
                        </td>
                        <td>
                            <button name="action" value="update_booking">Update</button>
                            <button class="delete" name="action" value="delete_booking" onclick="return confirm('Delete this booking?')">Delete</button>
                        </td>
                    </form>
                </tr>
                <?php } ?>
            </table>
        </div>
    </main>
</div>
</body>
</html>
