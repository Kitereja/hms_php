<?php
include 'admin_layout.php';
include 'db_connect.php';

$total_rooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms"))['total'];
$total_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings"))['total'];
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='guest'"))['total'];
$total_paid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(p.amount),0) AS total FROM payments p INNER JOIN bookings b ON p.booking_id = b.booking_id WHERE p.payment_status='completed'"))['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>

    <main class="main-content">
        <div class="page-title">
            <h1>Dashboard</h1>
            <p>Quick overview of your hotel system</p>
        </div>

        <div class="cards">
            <div class="card"><h3>Total Rooms</h3><p><?php echo $total_rooms; ?></p></div>
            <div class="card"><h3>Total Bookings</h3><p><?php echo $total_bookings; ?></p></div>
            <div class="card"><h3>Total Customers</h3><p><?php echo $total_customers; ?></p></div>
            <div class="card"><h3>Total Paid</h3><p>TSH <?php echo number_format($total_paid, 2); ?></p></div>
        </div>
    </main>
</div>
</body>
</html>
