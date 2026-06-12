<?php
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
    .pay-options { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    .pay-option { display:flex; align-items:center; gap:12px; padding:12px 16px; border:2px solid #eee; border-radius:10px; cursor:pointer; transition:0.2s; font-family:Arial,sans-serif; font-size:14px; background:#fff; }
    .pay-option:hover { border-color:#c8a96a; }
    .pay-option.selected { border-color:#c8a96a; background:#f8f5f0; }
    .pay-option input { display:none; }
    .pay-option .icon { width:36px; height:36px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:22px; }
    .pay-option .name { font-weight:bold; color:#0f172a; }
    .pay-option .desc { font-size:11px; color:#888; }
    .pay-details { display:none; margin-bottom:20px; }
    .pay-details.active { display:block; }
    .pay-details .sim-pin { text-align:center; padding:20px; background:#f8f5f0; border-radius:10px; margin-bottom:15px; }
    .pay-details .sim-pin .provider-icon { font-size:40px; margin-bottom:8px; text-align:center; }
    .pay-details .sim-pin .provider-icon img { width:48px; height:48px; }
    .pay-details .sim-pin p { font-size:13px; color:#555; margin-bottom:10px; font-family:Arial,sans-serif; }
    .pin-input { display:flex; gap:10px; justify-content:center; margin:10px 0; }
    .pin-input input { width:45px; height:45px; text-align:center; font-size:20px; border:2px solid #ddd; border-radius:8px; outline:none; font-family:Arial,sans-serif; }
    .pin-input input:focus { border-color:#c8a96a; }
    .processing-state { display:none; text-align:center; padding:30px 0; }
    .processing-state.active { display:block; }
    .spinner { display:inline-block; width:40px; height:40px; border:4px solid #c8a96a; border-top-color:transparent; border-radius:50%; animation:spin 0.8s linear infinite; margin-bottom:12px; }
    @keyframes spin { to { transform:rotate(360deg); } }
    .result-state { display:none; text-align:center; padding:20px 0; }
    .result-state.active { display:block; }
    .result-state .check { font-size:50px; color:#2a7; }
    .result-state .cross { font-size:50px; color:#c33; }
    .result-msg { font-size:16px; font-weight:bold; margin:8px 0; font-family:Arial,sans-serif; }
    .result-ref { font-size:13px; color:#888; font-family:Arial,sans-serif; }
    .hidden { display:none; }
    .summary { background:#f8f5f0; border-radius:10px; padding:16px; margin-bottom:20px; font-family:Arial,sans-serif; }
    .summary p { font-size:13px; color:#555; margin-bottom:4px; }
    .summary .total { font-size:22px; font-weight:bold; color:#0f172a; margin-top:6px; }
    .ussd-sim { background:#0f172a; color:#fff; padding:20px; border-radius:10px; font-family:monospace; font-size:14px; line-height:1.8; margin-bottom:15px; }
    .ussd-sim .blink { animation:blink 1s infinite; }
    @keyframes blink { 50% { opacity:0; } }
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
    <h2>Secure Payment</h2>
    <p class="login-sub">Simulated payment gateway — no real money</p>

    <?php if (isset($_GET['error'])) { ?>
      <p style="color:red; text-align:center;"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <div class="summary">
      <p><strong>Room:</strong> <?php echo $booking['room_name']; ?></p>
      <p><strong>Nights:</strong> <?php echo $nights; ?></p>
      <div class="total">TSH <?php echo number_format($total_amount, 2); ?></div>
    </div>

    <div id="stepSelect">
      <p style="font-size:13px;color:#888;margin-bottom:12px;font-family:Arial,sans-serif;">Choose payment method:</p>
      <div class="pay-options">
        <label class="pay-option"><input type="radio" name="method" value="mpesa" onchange="selectMethod(this)"><img class="icon" src="images/payment/mpesa.png" alt="M-Pesa"><div><div class="name">M-Pesa</div><div class="desc">Vodacom Tanzania</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="airtel" onchange="selectMethod(this)"><img class="icon" src="images/payment/airtel.svg" alt="Airtel"><div><div class="name">Airtel Money</div><div class="desc">Airtel Tanzania</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="tigo" onchange="selectMethod(this)"><img class="icon" src="images/payment/tigo.svg" alt="Tigo"><div><div class="name">Tigo Pesa</div><div class="desc">Tigo Tanzania</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="halopesa" onchange="selectMethod(this)"><img class="icon" src="images/payment/halopesa.png" alt="Halopesa"><div><div class="name">Halopesa</div><div class="desc">Halotel Tanzania</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="selcom" onchange="selectMethod(this)"><img class="icon" src="images/payment/selcom.png" alt="Selcom"><div><div class="name">Selcom</div><div class="desc">Online Payment Gateway</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="nmb" onchange="selectMethod(this)"><img class="icon" src="images/payment/nmb.png" alt="NMB"><div><div class="name">NMB Mkononi</div><div class="desc">NMB Bank Tanzania</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="crdb" onchange="selectMethod(this)"><img class="icon" src="images/payment/crdb.svg" alt="CRDB"><div><div class="name">CRDB SimBanking</div><div class="desc">CRDB Bank Tanzania</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="card" onchange="selectMethod(this)"><span class="icon">💳</span><div><div class="name">Card Payment</div><div class="desc">Visa / Mastercard</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="paypal" onchange="selectMethod(this)"><span class="icon" style="font-size:18px;font-weight:bold;color:#003087;">Pay</span><div><div class="name">PayPal</div><div class="desc">International payment</div></div></label>
        <label class="pay-option"><input type="radio" name="method" value="cash" onchange="selectMethod(this)"><span class="icon">💵</span><div><div class="name">Cash</div><div class="desc">Pay at reception</div></div></label>
      </div>
      <button class="btn-login" id="btnProceed" onclick="proceedPayment()" disabled>Proceed to Pay</button>
    </div>

    <div id="stepSim" class="hidden">
      <div id="pinSection"></div>
      <div id="processingSection" class="processing-state">
        <div class="spinner"></div>
        <p style="font-family:Arial,sans-serif;font-size:14px;color:#555;" id="processingMsg">Processing payment...</p>
      </div>
      <div id="resultSection" class="result-state"></div>
    </div>
  </div>
</section>

<script>
let selectedMethod = '';
let customerPhone = '';
const bookingId = '<?php echo $booking_id; ?>';
const amount = '<?php echo $total_amount; ?>';
const bookingRoom = '<?php echo addslashes($booking['room_name']); ?>';
const bookingCheckIn = '<?php echo $booking['check_in']; ?>';
const bookingCheckOut = '<?php echo $booking['check_out']; ?>';

const methodNames = {
  mpesa: { name: 'M-Pesa', icon: 'images/payment/mpesa.png', push: true },
  airtel: { name: 'Airtel Money', icon: 'images/payment/airtel.svg', push: true },
  tigo: { name: 'Tigo Pesa', icon: 'images/payment/tigo.svg', push: true },
  halopesa: { name: 'Halopesa', icon: 'images/payment/halopesa.png', push: true },
  selcom: { name: 'Selcom', icon: 'images/payment/selcom.png', ussd: '', pinLen: 4 },
  nmb: { name: 'NMB Mkononi', icon: 'images/payment/nmb.png', ussd: '*150*66#', pinLen: 4 },
  crdb: { name: 'CRDB SimBanking', icon: 'images/payment/crdb.svg', ussd: '*150*88#', pinLen: 4 },
  card: { name: 'Card', icon: '💳', ussd: '', pinLen: 3 },
  paypal: { name: 'PayPal', icon: '💳', ussd: '', pinLen: 0 },
  cash: { name: 'Cash', icon: '💵', ussd: '', pinLen: 0 },
};

function selectMethod(el) {
  selectedMethod = el.value;
  document.querySelectorAll('.pay-option').forEach(o => o.classList.remove('selected'));
  el.closest('.pay-option').classList.add('selected');
  document.getElementById('btnProceed').disabled = false;
}

function proceedPayment() {
  document.getElementById('stepSelect').classList.add('hidden');
  document.getElementById('stepSim').classList.remove('hidden');

  const meta = methodNames[selectedMethod];
  const pinSection = document.getElementById('pinSection');
  const processingSection = document.getElementById('processingSection');
  const resultSection = document.getElementById('resultSection');

  processingSection.classList.remove('active');
  resultSection.classList.remove('active');

  if (selectedMethod === 'cash') {
    showResult(true, 'Booking confirmed — pay TSH ' + Number(amount).toLocaleString() + ' at reception upon arrival.', 'CASH-' + Date.now());
    savePayment('cash', 'CASH-' + Date.now());
    return;
  }

  if (selectedMethod === 'paypal') {
    pinSection.innerHTML = `
      <div class="sim-pin" style="text-align:center;">
        <div style="font-size:28px;font-weight:bold;color:#003087;margin-bottom:4px;">PayPal</div>
        <p style="font-size:13px;color:#555;">Simulated PayPal Checkout</p>
        <p style="font-size:18px;font-weight:bold;margin:12px 0;">TSH ${Number(amount).toLocaleString()}</p>
        <div class="form-group"><label>PayPal Email</label><input type="email" id="paypalEmail" placeholder="buyer@example.com" value="buyer@paypal.com"></div>
        <div class="form-group"><label>Password</label><input type="password" id="paypalPass" placeholder="••••••••" value="password123"></div>
        <button class="btn-login" onclick="simulateProcessing()" style="background:#003087;">Pay with PayPal</button>
        <p style="font-size:11px;color:#888;margin-top:8px;">Sandbox simulation — no real charge</p>
      </div>`;
    return;
  }

  if (selectedMethod === 'card') {
    pinSection.innerHTML = `
      <div class="sim-pin">
        <div class="provider-icon"><img src="${meta.icon}" alt="${meta.name}" style="width:48px;height:48px;"></div>
        <p>Enter simulated <strong>${meta.name}</strong> details</p>
        <div class="form-group"><label>Card Number</label><input type="text" id="simCard" placeholder="4242 4242 4242 4242" maxlength="19"></div>
        <div style="display:flex;gap:10px;">
          <div class="form-group" style="flex:1;"><label>Expiry</label><input type="text" id="simExpiry" placeholder="MM/YY" maxlength="5"></div>
          <div class="form-group" style="flex:1;"><label>CVV</label><input type="text" id="simCvv" placeholder="123" maxlength="4"></div>
        </div>
        <button class="btn-login" onclick="simulateProcessing()">Pay TSH ${Number(amount).toLocaleString()}</button>
      </div>`;
    return;
  }

  if (meta.push) {
    pinSection.innerHTML = `
      <div class="sim-pin">
        <div class="provider-icon"><img src="${meta.icon}" alt="${meta.name}" style="width:48px;height:48px;"></div>
        <p>Pay with <strong>${meta.name}</strong></p>
        <p style="font-size:13px;color:#555;">Amount: <strong>TSH ${Number(amount).toLocaleString()}</strong></p>
        <div class="form-group" style="margin-top:12px;">
          <label>Phone Number</label>
          <input type="tel" id="pushPhone" placeholder="e.g. 0712345678" maxlength="13" style="width:100%;text-align:center;font-size:16px;">
        </div>
        <p style="font-size:12px;color:#888;margin-top:8px;">A payment request will be sent to this number</p>
        <button class="btn-login" onclick="pushPayment()" style="margin-top:10px;">Send Payment Request</button>
      </div>`;
    return;
  }

  let provIcon = meta.icon.startsWith('images/') ? '<img src="' + meta.icon + '" alt="' + meta.name + '" style="width:48px;height:48px;">' : meta.icon;
  let pinHtml = `<div class="sim-pin"><div class="provider-icon">${provIcon}</div><p>Simulating <strong>${meta.name}</strong> payment</p>`;
  if (meta.ussd) {
    pinHtml += `<div class="ussd-sim">> Dial ${meta.ussd}<br>> Enter amount: TSH ${Number(amount).toLocaleString()}<br>> Enter PIN: <span class="blink">▊</span></div>`;
  }
  pinHtml += `<p style="font-size:12px;color:#888;font-family:Arial,sans-serif;">Enter your simulated ${meta.name} PIN to proceed</p>`;
  pinHtml += `<div class="pin-input">`;
  for (let i = 0; i < meta.pinLen; i++) {
    pinHtml += `<input type="password" maxlength="1" class="pin-box" oninput="pinNext(this)">`;
  }
  pinHtml += `</div>`;
  pinHtml += `<button class="btn-login" onclick="simulateProcessing()">Confirm Payment</button>`;
  pinHtml += `</div>`;
  pinSection.innerHTML = pinHtml;

  if (meta.pinLen > 0) {
    document.querySelectorAll('.pin-box')[0]?.focus();
  }
}

function pinNext(el) {
  if (el.value.length === 1) {
    const next = el.nextElementSibling;
    if (next) next.focus();
  }
}

function simulateProcessing() {
  document.getElementById('pinSection').innerHTML = '';
  document.getElementById('processingSection').classList.add('active');
  document.getElementById('processingMsg').textContent = 'Processing ' + methodNames[selectedMethod].name + ' payment...';
  document.getElementById('resultSection').classList.remove('active');

  setTimeout(() => {
    document.getElementById('processingMsg').textContent = 'Verifying with provider...';
  }, 1500);

  setTimeout(() => {
    document.getElementById('processingSection').classList.remove('active');
    const success = Math.random() <= 0.9;
    const ref = selectedMethod.toUpperCase() + '-' + Date.now();
    if (success) {
      showResult(true, methodNames[selectedMethod].name + ' payment successful!', ref);
      savePayment(selectedMethod, ref);
    } else {
      showResult(false, methodNames[selectedMethod].name + ' payment declined. Insufficient balance.', ref);
    }
  }, 3500);
}

function showResult(success, msg, ref) {
  const el = document.getElementById('resultSection');
  el.classList.add('active');
  var waLink = '';
  if (success && customerPhone) {
    var num = customerPhone.replace(/[^0-9]/g, '');
    if (num.startsWith('0')) num = '255' + num.slice(1);
    if (!num.startsWith('255')) num = '255' + num;
    var waMsg = encodeURIComponent('Hotel De Mag - Booking Confirmed!\nRoom: ' + bookingRoom + '\nCheck-in: ' + bookingCheckIn + '\nCheck-out: ' + bookingCheckOut + '\nAmount: TSH ' + Number(amount).toLocaleString() + '\nRef: ' + ref + '\nThank you for choosing Hotel De Mag.');
    waLink = '<a href="https://wa.me/' + num + '?text=' + waMsg + '" target="_blank" class="btn-login" style="display:block;text-align:center;text-decoration:none;margin-top:10px;background:#25D366;">Send Receipt via WhatsApp</a>';
  }
  el.innerHTML = `
    <div class="${success ? 'check' : 'cross'}">${success ? '&#10003;' : '&#10007;'}</div>
    <div class="result-msg" style="color:${success ? '#2a7' : '#c33'}">${msg}</div>
    <div class="result-ref">Ref: ${ref}</div>
    ${waLink}
    ${success ? '<a href="payment_success.php?booking_id=' + bookingId + '" class="btn-login" style="display:block;text-align:center;text-decoration:none;margin-top:10px;">View Receipt</a>' : '<button class="btn-login" onclick="location.reload()" style="margin-top:16px;">Try Again</button>'}
  `;
}

function pushPayment() {
  customerPhone = document.getElementById('pushPhone').value.trim();
  var digits = customerPhone.replace(/[^0-9]/g, '');
  if (digits.length !== 10) { alert('Please enter a valid 10-digit phone number (e.g. 0712345678)'); return; }
  var meta = methodNames[selectedMethod];
  document.getElementById('pinSection').innerHTML = `
    <div class="sim-pin">
      <div class="provider-icon"><img src="${meta.icon}" alt="${meta.name}" style="width:48px;height:48px;"></div>
      <p style="font-size:13px;">Payment to <strong>Hotel De Mag</strong></p>
      <p style="font-size:13px;color:#555;">Phone: <strong>${customerPhone}</strong></p>
      <p style="font-size:18px;font-weight:bold;margin:10px 0;">TSH ${Number(amount).toLocaleString()}</p>
      <p style="font-size:12px;color:#888;">Enter your ${meta.name} PIN to authorize payment</p>
      <div class="pin-input">
        <input type="password" maxlength="1" class="pin-box" oninput="pinNext(this)">
        <input type="password" maxlength="1" class="pin-box" oninput="pinNext(this)">
        <input type="password" maxlength="1" class="pin-box" oninput="pinNext(this)">
        <input type="password" maxlength="1" class="pin-box" oninput="pinNext(this)">
      </div>
      <button class="btn-login" onclick="simulateProcessing()">Confirm Payment</button>
    </div>`;
  document.querySelectorAll('.pin-box')[0]?.focus();
}

function savePayment(method, ref) {
  var formData = new FormData();
  formData.append('booking_id', bookingId);
  formData.append('amount', amount);
  formData.append('payment_method', method);
  formData.append('transaction_ref', ref);

  fetch('payment_process.php', {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  }).catch(function(){});
}
</script>

</body>
</html>
