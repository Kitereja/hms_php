<?php
include 'admin_layout.php';
$total_rooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms"))['total'];
$available_rooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE status='available'"))['total'];
$booked_rooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE status='booked'"))['total'];
$total_paid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(p.amount),0) AS total FROM payments p INNER JOIN bookings b ON p.booking_id = b.booking_id WHERE p.payment_status='completed'"))['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>

    <main class="main-content">
        <div class="page-title">
            <h1>View Reports</h1>
            <p>Summary of hotel performance</p>
        </div>

        <div class="cards">
            <div class="card"><h3>Total Rooms</h3><p><?php echo $total_rooms; ?></p></div>
            <div class="card"><h3>Available Rooms</h3><p><?php echo $available_rooms; ?></p></div>
            <div class="card"><h3>Booked Rooms</h3><p><?php echo $booked_rooms; ?></p></div>
            <div class="card"><h3>Total Revenue</h3><p>TSH <?php echo number_format($total_paid, 2); ?></p></div>
        </div>
    </main>
</div>
</body>
</html>
