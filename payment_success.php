<?php
include 'db_connect.php';
$booking_id = isset($_GET['booking_id']) ? mysqli_real_escape_string($conn, $_GET['booking_id']) : 0;
$sql = "SELECT * FROM bookings WHERE booking_id='$booking_id' LIMIT 1";
$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($result);

$payment = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM payments WHERE booking_id='$booking_id' ORDER BY payment_id DESC LIMIT 1"));

$check_in = new DateTime($booking['check_in']);
$check_out = new DateTime($booking['check_out']);
$nights = max(1, $check_in->diff($check_out)->days);
$total = $nights * $booking['price_per_night'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Success - Hotel De Mag</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
<section class="login-section">
  <div class="login-card" style="text-align:center;">
    <div style="font-size:60px;color:#2a7;margin-bottom:10px;">&#10003;</div>
    <h2>Payment Successful!</h2>
    <p class="login-sub">Your booking is confirmed. Thank you for choosing Hotel De Mag.</p>
    <?php if ($booking) { ?>
      <div class="summary" style="background:#f8f5f0;border-radius:10px;padding:16px;margin:20px 0;font-family:Arial,sans-serif;text-align:left;">
        <p><strong>Booking ID:</strong> #<?php echo $booking['booking_id']; ?></p>
        <p><strong>Room:</strong> <?php echo $booking['room_name']; ?></p>
        <p><strong>Check-in:</strong> <?php echo $booking['check_in']; ?></p>
        <p><strong>Check-out:</strong> <?php echo $booking['check_out']; ?></p>
        <p><strong>Guests:</strong> <?php echo $booking['guests']; ?></p>
        <p><strong>Total Paid:</strong> TSH <?php echo number_format($total, 2); ?></p>
        <?php if ($payment) { ?>
        <p><strong>Reference:</strong> <?php echo $payment['transaction_ref']; ?></p>
        <?php } ?>
        <p><strong>Status:</strong> Confirmed</p>
      </div>
    <?php } ?>
    <a href="index.php" class="btn-login" style="display:block;text-align:center;text-decoration:none;">Back Home</a>
  </div>
</section>
</body>
</html>