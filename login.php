<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Hotel De Mag</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

<!-- NAVBAR -->
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

<!-- LOGIN FORM -->
<section class="login-section">
  <div class="login-card">
    <h2>Welcome Back</h2>
    <p class="login-sub">Sign in to your Hotel De Mag account</p>

    <?php if (isset($_GET['success'])) { ?>
      <p style="color:green; text-align:center;"><?php echo $_GET['success']; ?></p>
    <?php } ?>
    <?php if (isset($_GET['error'])) { ?>
      <p style="color:red; text-align:center;"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <div class="tabs">
      <button class="tab active" onclick="showTab('login', this)">Login</button>
      <button class="tab" onclick="showTab('signup', this)">Sign Up</button>
    </div>

    <!-- LOGIN TAB -->
    <div id="login" class="tab-content active">
      <form id="loginForm">
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="e.g. john@email.com" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
        </div>
        <button class="btn-login" type="submit">Login</button>
        <p style="text-align:center;margin-top:10px;"><a href="forgot_password.php" style="color:#c8a96a;font-size:13px;text-decoration:none;font-family:Arial,sans-serif;">Forgot Password?</a></p>
      </form>
      <p class="form-note">Don't have an account? <a href="#" onclick="showTab('signup', document.querySelectorAll('.tab')[1])">Sign up</a></p>
    </div>

    <!-- SIGNUP TAB -->
    <div id="signup" class="tab-content">
      <form action="signup_process.php" method="POST">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="full_name" placeholder="e.g. John Doe" required>
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="e.g. john@email.com" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" id="signupPassword" placeholder="Create a password" required oninput="validatePassword()">
          <div id="passwordReqs" style="font-size:12px;margin-top:6px;color:#888;font-family:Arial,sans-serif;">
            <div id="req-upper">⬜ Uppercase letter</div>
            <div id="req-lower">⬜ Lowercase letter</div>
            <div id="req-number">⬜ Number</div>
            <div id="req-special">⬜ Special character (!@#$%^&amp;*)</div>
          </div>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" placeholder="Repeat password" required>
        </div>
        <button class="btn-login" type="submit" id="signupBtn">Create Account</button>
      </form>
      <p class="form-note">Already have an account? <a href="#" onclick="showTab('login', document.querySelectorAll('.tab')[0])">Login</a></p>
    </div>

  </div>
</section>

<script>
function showTab(id, btn) {
  document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  btn.classList.add('active');
}

function validatePassword() {
  var pwd = document.getElementById('signupPassword').value;
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

document.querySelector('#signup form').addEventListener('submit', function(e) {
  var pwd = document.getElementById('signupPassword').value;
  var err = [];
  if (!/[A-Z]/.test(pwd)) err.push('uppercase letter');
  if (!/[a-z]/.test(pwd)) err.push('lowercase letter');
  if (!/[0-9]/.test(pwd)) err.push('number');
  if (!/[!@#$%^&*(),.?":{}|<>]/.test(pwd)) err.push('special character');
  if (err.length) {
    e.preventDefault();
    alert('Password must contain at least one ' + err.join(', ') + '.');
  }
});

document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();
  var formData = new FormData(this);
  fetch('login_process.php', {
    method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(function(r) { return r.json(); })
  .then(function(data) {
    if (data.success) { sessionStorage.setItem('hms_logged_in', '1'); alert('Login successful'); window.location.href = data.redirect; }
    else { alert(data.error); }
  })
  .catch(function() { alert('Network error. Please try again.'); });
});
</script>
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
</script>

</body>
</html>
