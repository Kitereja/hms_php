<?php
session_start();
include 'db_connect.php';

// Beginner admin protection
// Login first using an account where role = 'admin'


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php?error=Please login as admin first');
    exit();
}

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

// Dashboard reports
$total_rooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms"))['total'];
$total_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings"))['total'];
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='guest'"))['total'];
$total_paid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount),0) AS total FROM payments WHERE payment_status='paid'"))['total'];

$rooms = mysqli_query($conn, "SELECT * FROM rooms ORDER BY room_id DESC");
$bookings = mysqli_query($conn, "SELECT * FROM bookings ORDER BY booking_id DESC");
$customers = mysqli_query($conn, "SELECT * FROM users WHERE role='guest' ORDER BY user_id DESC");
$payments = mysqli_query($conn, "SELECT p.*, b.guest_name, b.room_name FROM payments p JOIN bookings b ON p.booking_id=b.booking_id ORDER BY p.payment_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        .top { background: #222; color: white; padding: 15px 30px; display: flex; justify-content: space-between; }
        .top a { color: white; text-decoration: none; margin-left: 15px; }
        .container { width: 95%; margin: 20px auto; }
        .cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 5px #ccc; }
        .card h3 { margin: 0; color: #555; }
        .card p { font-size: 28px; margin: 10px 0 0; font-weight: bold; }
        .section { background: white; margin-bottom: 25px; padding: 20px; border-radius: 8px; box-shadow: 0 0 5px #ccc; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #333; color: white; }
        input, select { padding: 8px; margin: 5px; }
        button { padding: 8px 12px; background: #222; color: white; border: none; cursor: pointer; }
        .delete { background: crimson; }
        .success { background: #d4edda; color: #155724; padding: 10px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; }
        .form-row { display: flex; flex-wrap: wrap; align-items: center; }
    </style>
</head>
<body>

<div class="top">
    <h2>Hotel Admin Dashboard</h2>
    <div>
        <a href="index.php">Website</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <?php if ($msg != '') { echo "<p class='success'>$msg</p>"; } ?>
    <?php if ($error != '') { echo "<p class='error'>$error</p>"; } ?>

    <div class="cards">
        <div class="card"><h3>Total Rooms</h3><p><?php echo $total_rooms; ?></p></div>
        <div class="card"><h3>Total Bookings</h3><p><?php echo $total_bookings; ?></p></div>
        <div class="card"><h3>Total Customers</h3><p><?php echo $total_customers; ?></p></div>
        <div class="card"><h3>Total Paid</h3><p>$<?php echo number_format($total_paid, 2); ?></p></div>
    </div>

    <div class="section" id="rooms">
        <h2>Manage Rooms</h2>
        <form action="admin_process.php" method="POST" enctype="multipart/form-data" class="form-row">
            <input type="hidden" name="action" value="add_room">
            <input type="text" name="room_name" placeholder="Room name" required>
            <input type="text" name="room_type" placeholder="Room type" required>
            <input type="number" name="price" placeholder="Price" required>
            <input type="number" name="capacity" placeholder="Capacity" required>
            <input type="file" name="image" accept="image/*" placeholder="Upload room image">
            <select name="status">
                <option value="available">Available</option>
                <option value="booked">Booked</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <button type="submit">Add Room</button>
        </form>

        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Type</th><th>Price</th><th>Capacity</th><th>Status</th><th>Action</th>
            </tr>
            <?php while($room = mysqli_fetch_assoc($rooms)) { ?>
            <tr>
                <form action="admin_process.php" method="POST" enctype="multipart/form-data">
                    <td><?php echo $room['room_id']; ?><input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>"></td>
                    <td><input type="text" name="room_name" value="<?php echo $room['room_name']; ?>"></td>
                    <td><input type="text" name="room_type" value="<?php echo $room['room_type']; ?>"></td>
                    <td><input type="number" name="price" value="<?php echo $room['price']; ?>"></td>
                    <td><input type="number" name="capacity" value="<?php echo $room['capacity']; ?>"></td>
                    <td>
                        <select name="status">
                            <option value="available" <?php if($room['status']=='available') echo 'selected'; ?>>Available</option>
                            <option value="booked" <?php if($room['status']=='booked') echo 'selected'; ?>>Booked</option>
                            <option value="maintenance" <?php if($room['status']=='maintenance') echo 'selected'; ?>>Maintenance</option>
                        </select>
                    </td>
                    <td>
                        <button name="action" value="update_room">Update</button>
                        <button class="delete" name="action" value="delete_room" onclick="return confirm('Delete this room?')">Delete</button>
                    </td>
                </form>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div class="section" id="bookings">
        <h2>Manage Bookings</h2>
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
                            <option value="pending" <?php if($booking['booking_status']=='pending') echo 'selected'; ?>>Pending</option>
                            <option value="confirmed" <?php if($booking['booking_status']=='confirmed') echo 'selected'; ?>>Confirmed</option>
                            <option value="cancelled" <?php if($booking['booking_status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
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

    <div class="section" id="customers">
        <h2>Manage Customers</h2>
        <table>
            <tr><th>ID</th><th>Full Name</th><th>Email</th><th>Created At</th><th>Action</th></tr>
            <?php while($customer = mysqli_fetch_assoc($customers)) { ?>
            <tr>
                <td><?php echo $customer['user_id']; ?></td>
                <td><?php echo $customer['full_name']; ?></td>
                <td><?php echo $customer['email']; ?></td>
                <td><?php echo $customer['created_at']; ?></td>
                <td>
                    <form action="admin_process.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $customer['user_id']; ?>">
                        <button class="delete" name="action" value="delete_customer" onclick="return confirm('Delete this customer?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div class="section" id="reports">
        <h2>View Reports / Payments</h2>
        <table>
            <tr><th>Payment ID</th><th>Booking ID</th><th>Guest</th><th>Room</th><th>Amount</th><th>Method</th><th>Reference</th><th>Status</th><th>Date</th></tr>
            <?php while($pay = mysqli_fetch_assoc($payments)) { ?>
            <tr>
                <td><?php echo $pay['payment_id']; ?></td>
                <td><?php echo $pay['booking_id']; ?></td>
                <td><?php echo $pay['guest_name']; ?></td>
                <td><?php echo $pay['room_name']; ?></td>
                <td>$<?php echo $pay['amount']; ?></td>
                <td><?php echo $pay['payment_method']; ?></td>
                <td><?php echo $pay['transaction_ref']; ?></td>
                <td><?php echo $pay['payment_status']; ?></td>
                <td><?php echo $pay['payment_date']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

</div>
</body>
</html>
