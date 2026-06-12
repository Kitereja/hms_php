<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Hotel De Mag</title>
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
    <h2>Forgot Password</h2>
    <p class="login-sub">Enter your email to receive a reset link</p>

    <?php if (isset($_GET['error'])) { ?>
      <p style="color:red; text-align:center;"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <?php if (isset($_GET['success'])) { ?>
      <p style="color:green; text-align:center;"><?php echo $_GET['success']; ?></p>
    <?php } ?>

    <form action="forgot_password_process.php" method="POST">
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="e.g. john@email.com" required>
      </div>
      <button class="btn-login" type="submit">Send Reset Link</button>
    </form>
    <p class="form-note"><a href="login.php">Back to Login</a></p>
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
</script>

</body>
</html>
