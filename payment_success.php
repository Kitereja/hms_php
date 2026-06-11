<?php
include 'db_connect.php';
$booking_id = isset($_GET['booking_id']) ? mysqli_real_escape_string($conn, $_GET['booking_id']) : 0;
$sql = "SELECT * FROM bookings WHERE booking_id='$booking_id' LIMIT 1";
$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Success</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
<section class="login-section">
  <div class="login-card">
    <h2>Payment Successful</h2>
    <p class="login-sub">Your mock payment has been saved and your booking is confirmed.</p>
    <?php if ($booking) { ?>
      <p><strong>Booking ID:</strong> <?php echo $booking['booking_id']; ?></p>
      <p><strong>Room:</strong> <?php echo $booking['room_name']; ?></p>
      <p><strong>Status:</strong> <?php echo $booking['booking_status']; ?></p>
    <?php } ?>
    <a href="index.php" class="btn-login" style="display:block;text-align:center;text-decoration:none;">Back Home</a>
  </div>
</section>
</body>
</html>
