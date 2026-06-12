<?php
include 'db_connect.php';

$token = isset($_GET['token']) ? mysqli_real_escape_string($conn, $_GET['token']) : '';
$valid = false;
$email = '';

if (!empty($token)) {
    $sql = "SELECT email FROM users WHERE reset_token='$token' AND reset_token_expiry > NOW() LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $valid = true;
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - Hotel De Mag</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="logo">HOTEL DE MAG</a>
  <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
  <ul class="nav-links" id="navLinks">
    <li><a href="index.php">Home</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="room.php">Rooms</a></li>
    <li><a href="services.php">Services</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
  <a href="login.php" class="btn-outline">Login</a>
</nav>

<section class="login-section">
  <div class="login-card">
    <?php if ($valid) { ?>
      <h2>Reset Password</h2>
      <p class="login-sub">Enter your new password for <?php echo $email; ?></p>

      <?php if (isset($_GET['error'])) { ?>
        <p style="color:red; text-align:center;"><?php echo $_GET['error']; ?></p>
      <?php } ?>

      <form action="reset_password_process.php" method="POST">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div class="form-group">
          <label>New Password</label>
          <input type="password" name="password" id="resetPassword" placeholder="Enter new password" required oninput="validatePassword()">
          <div id="passwordReqs" style="font-size:12px;margin-top:6px;color:#888;font-family:Arial,sans-serif;">
            <div id="req-upper">⬜ Uppercase letter</div>
            <div id="req-lower">⬜ Lowercase letter</div>
            <div id="req-number">⬜ Number</div>
            <div id="req-special">⬜ Special character (!@#$%^&amp;*)</div>
          </div>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" placeholder="Repeat new password" required>
        </div>
        <button class="btn-login" type="submit" id="resetBtn">Reset Password</button>
      </form>
      <p class="form-note"><a href="login.php">Back to Login</a></p>
    <?php } else { ?>
      <h2>Invalid or Expired Link</h2>
      <p class="login-sub">This password reset link is invalid or has expired.</p>
      <p class="form-note"><a href="forgot_password.php">Request a new reset link</a></p>
    <?php } ?>
  </div>
</section>

<footer>
  <div class="footer-grid">
    <div class="footer-col">
      <h3>HOTEL DE MAG</h3>
      <p>Luxury, comfort, and unforgettable experiences.</p>
    </div>
    <div class="footer-col">
      <h3>Quick Links</h3>
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="room.php">Rooms</a>
      <a href="services.php">Services</a>
      <a href="contact.php">Contact</a>
    </div>
    <div class="footer-col">
      <h3>Services</h3>
      <a href="services.php">Swimming Pool</a>
      <a href="services.php">Spa &amp; Wellness</a>
      <a href="services.php">Restaurant</a>
    </div>
    <div class="footer-col">
      <h3>Contact</h3>
      <p>hoteldemag@gmail.com</p>
      <p>+255 764 966 568</p>
      <p>Dar es Salaam, Tanzania</p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2026 Hotel De Mag. All rights reserved.</p>
  </div>
</footer>

<script>
function toggleMenu() {
  document.getElementById('navLinks').classList.toggle('open');
}

function validatePassword() {
  var pwd = document.getElementById('resetPassword').value;
  var checks = {
    upper: /[A-Z]/.test(pwd),
    lower: /[a-z]/.test(pwd),
    number: /[0-9]/.test(pwd),
    special: /[!@#$%^&*(),.?":{}|<>]/.test(pwd)
  };
  var allValid = true;
  for (var key in checks) {
    var el = document.getElementById('req-' + key);
    if (checks[key]) { el.innerHTML = '✅ ' + el.textContent.slice(2); } else { el.innerHTML = '⬜ ' + el.textContent.slice(2); allValid = false; }
  }
}

document.querySelector('form').addEventListener('submit', function(e) {
  var pwd = document.getElementById('resetPassword').value;
  var confirm = document.querySelector('input[name="confirm_password"]').value;
  var err = [];
  if (!/[A-Z]/.test(pwd)) err.push('uppercase letter');
  if (!/[a-z]/.test(pwd)) err.push('lowercase letter');
  if (!/[0-9]/.test(pwd)) err.push('number');
  if (!/[!@#$%^&*(),.?":{}|<>]/.test(pwd)) err.push('special character');
  if (err.length) {
    e.preventDefault();
    alert('Password must contain at least one ' + err.join(', ') + '.');
  } else if (pwd !== confirm) {
    e.preventDefault();
    alert('Passwords do not match.');
  }
});
</script>

</body>
</html>
