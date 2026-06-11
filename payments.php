<?php
include 'admin_layout.php';
$payments = mysqli_query($conn, "SELECT p.*, b.guest_name, b.room_name FROM payments p JOIN bookings b ON p.booking_id=b.booking_id ORDER BY p.payment_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payments</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>

    <main class="main-content">
        <div class="page-title">
            <h1>Payments</h1>
            <p>View customer payment records</p>
        </div>

        <div class="panel">
            <table>
                <tr><th>Payment ID</th><th>Booking ID</th><th>Guest</th><th>Room</th><th>Amount</th><th>Method</th><th>Reference</th><th>Status</th><th>Date</th></tr>
                <?php while($pay = mysqli_fetch_assoc($payments)) { ?>
                <tr>
                    <td><?php echo $pay['payment_id']; ?></td>
                    <td><?php echo $pay['booking_id']; ?></td>
                    <td><?php echo $pay['guest_name']; ?></td>
                    <td><?php echo $pay['room_name']; ?></td>
                    <td>TSH <?php echo number_format($pay['amount'], 0); ?></td>
                    <td><?php echo ucwords(str_replace('_', ' ', $pay['payment_method'] ?? 'N/A')); ?></td>
                    <td><?php echo $pay['transaction_ref']; ?></td>
                    <td><span class="status <?php echo $pay['payment_status'] ?: 'unknown'; ?>"><?php echo $pay['payment_status'] ?: 'Unknown'; ?></span></td>
                    <td><?php echo date('M j, Y g:i A', strtotime($pay['created_at'])); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </main>
</div>
</body>
</html>
