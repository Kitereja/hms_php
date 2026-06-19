<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['booking_id'])) {
    die('Booking ID is missing');
}

$booking_id = mysqli_real_escape_string($conn, $_GET['booking_id']);
$sql = "SELECT * FROM bookings WHERE booking_id='$booking_id' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die('Booking not found');
}

$booking = mysqli_fetch_assoc($result);
$check_in = new DateTime($booking['check_in']);
$check_out = new DateTime($booking['check_out']);
$nights = $check_in->diff($check_out)->days;
if ($nights < 1) { $nights = 1; }
$total_amount = $nights * $booking['price_per_night'];

$already_paid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM payments WHERE booking_id='$booking_id' AND payment_status='completed' LIMIT 1"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment - Hotel De Mag</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/login.css">
  <style>
    .summary { background:#f8f5f0; border-radius:10px; padding:16px; margin-bottom:20px; font-family:Arial,sans-serif; }
    .summary p { font-size:13px; color:#555; margin-bottom:4px; }
    .summary .total { font-size:22px; font-weight:bold; color:#0f172a; margin-top:6px; }
    .snippe-btn { display:flex; align-items:center; justify-content:center; gap:10px; width:100%; padding:14px; background:#0f172a; color:#fff; border:none; border-radius:8px; font-size:15px; font-weight:bold; font-family:Arial,sans-serif; cursor:pointer; text-decoration:none; transition:0.2s; margin-bottom:20px; }
    .snippe-btn:hover { background:#2563eb; }
    .snippe-btn img { width:24px; height:24px; }
    .or-divider { text-align:center; font-size:13px; color:#888; font-family:Arial,sans-serif; margin:16px 0; position:relative; }
    .or-divider::before, .or-divider::after { content:''; position:absolute; top:50%; width:42%; height:1px; background:#ddd; }
    .or-divider::before { left:0; } .or-divider::after { right:0; }
    .form-group { display:flex; flex-direction:column; gap:5px; margin-bottom:14px; }
    .form-group label { font-size:12px; font-weight:bold; color:#0f172a; font-family:Arial,sans-serif; text-transform:uppercase; letter-spacing:0.5px; }
    .form-group input { padding:10px 13px; border:1px solid #ddd; border-radius:6px; font-size:14px; font-family:Arial,sans-serif; }
    .form-group input:focus { outline:none; border-color:#c8a96a; box-shadow:0 0 0 3px rgba(200,169,106,0.15); }
    .steps { display:flex; gap:8px; margin-bottom:24px; }
    .step { flex:1; text-align:center; padding:8px; border-radius:8px; font-size:12px; font-family:Arial,sans-serif; background:#f0f0f0; color:#888; }
    .step.active { background:#c8a96a; color:#0f172a; font-weight:bold; }
    .step.done { background:#2a7; color:#fff; }
    .info-box { background:#e8f4fd; border:1px solid #b8d8f0; border-radius:8px; padding:12px; margin-bottom:16px; font-size:13px; font-family:Arial,sans-serif; color:#1a5276; }
  </style>
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="logo">HOTEL DE MAG</a>
  <ul class="nav-links" id="navLinks">
    <li><a href="index.php">Home</a></li>
    <li><a href="room.php">Rooms</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
</nav>

<section class="login-section">
  <div class="login-card">
    <h2>Complete Payment</h2>

    <?php if ($already_paid) { ?>
      <p class="login-sub">This booking has already been paid for and confirmed.</p>
      <div class="summary">
        <p><strong>Room:</strong> <?php echo $booking['room_name']; ?></p>
        <p><strong>Status:</strong> Confirmed</p>
        <div class="total">TSH <?php echo number_format($total_amount, 2); ?></div>
      </div>
      <a href="index.php" class="btn-login" style="display:block;text-align:center;text-decoration:none;">Back Home</a>
      <?php exit; } ?>

    <div class="steps">
      <div class="step active" id="step1Label">1. Pay on Snippe</div>
      <div class="step" id="step2Label">2. Confirm Payment</div>
      <div class="step" id="step3Label">3. Done</div>
    </div>

    <div class="summary">
      <p><strong>Room:</strong> <?php echo $booking['room_name']; ?></p>
      <p><strong>Nights:</strong> <?php echo $nights; ?></p>
      <div class="total">TSH <?php echo number_format($total_amount, 2); ?></div>
    </div>

    <div id="step1">
      <div class="info-box">
        Pay securely via Snippe — Tanzania's trusted payment platform. Accepts M-Pesa, Airtel Money, Mixx by Yas, and Halopesa.
      </div>
      <a href="https://snippe.me/pay/hoteldemag" target="_blank" class="snippe-btn" onclick="onSnippeClicked()">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect width="24" height="24" rx="4" fill="#2563eb"/><text x="12" y="16" text-anchor="middle" fill="white" font-size="12" font-weight="bold">S</text></svg>
        Pay with Snippe
      </a>
      <button class="btn-login" onclick="showStep2()" id="btnPaid" disabled>I've Paid — Enter Reference</button>
    </div>

    <div id="step2" style="display:none;">
      <form id="confirmForm" method="POST" action="payment_process.php">
        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
        <input type="hidden" name="amount" value="<?php echo $total_amount; ?>">
        <input type="hidden" name="payment_method" value="snippe">

        <div class="form-group">
          <label>Phone Number Used</label>
          <input type="tel" name="phone" placeholder="e.g. 0712345678" maxlength="13" required>
        </div>
        <div class="form-group">
          <label>Transaction Reference</label>
          <input type="text" name="transaction_ref" placeholder="Reference from Snippe" required>
        </div>
        <div class="form-group">
          <label>Amount Paid (TSH)</label>
          <input type="number" name="amount_paid" value="<?php echo $total_amount; ?>" required>
        </div>

        <button type="submit" class="btn-login" style="margin-top:6px;">Submit for Confirmation</button>
      </form>
    </div>

    <div id="step3" style="display:none;">
      <div style="text-align:center;padding:20px 0;">
        <div style="font-size:50px;color:#2a7;">&#10003;</div>
        <div class="result-msg" style="font-size:16px;font-weight:bold;margin:8px 0;">Payment Confirmed!</div>
        <p style="font-size:13px;color:#888;font-family:Arial,sans-serif;">Your booking is confirmed. Redirecting to receipt...</p>
      </div>
    </div>
  </div>
</section>

<script>
function onSnippeClicked() {
  document.getElementById('btnPaid').disabled = false;
  document.getElementById('step1Label').classList.remove('active');
  document.getElementById('step1Label').classList.add('done');
}

function showStep2() {
  document.getElementById('step1').style.display = 'none';
  document.getElementById('step2').style.display = 'block';
  document.getElementById('step2Label').classList.add('active');
}

<?php if (isset($_GET['success'])) { ?>
  document.getElementById('step1').style.display = 'none';
  document.getElementById('step2').style.display = 'none';
  document.getElementById('step3').style.display = 'block';
  document.getElementById('step1Label').classList.add('done');
  document.getElementById('step2Label').classList.add('done');
  document.getElementById('step3Label').classList.add('active');
<?php } ?>
</script>

</body>
</html>
