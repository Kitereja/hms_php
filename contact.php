<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - Hotel De Mag</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/contact.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    <li><a href="contact.php" class="active">Contact</a></li>
  </ul>
  <a href="login.php" class="btn-outline">Login</a>
</nav>

<!-- HEADER -->
<header class="contact-header">
  <h1>Contact Us</h1>
  <p>We'd love to hear from you — reach out any time</p>
</header>

<!-- CONTACT BODY -->
<section class="contact-body">

  <!-- INFO CARDS -->
  <div class="contact-info">
    <div class="info-card">
      <div class="info-icon"><i class="fas fa-envelope"></i></div>
      <h3>Email</h3>
      <p>hoteldemag@gmail.com</p>
    </div>
    <div class="info-card">
      <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
      <h3>Phone</h3>
      <p><a href="https://wa.me/255764966568" target="_blank" style="color:#222;text-decoration:none;">+255 764 966 568</a></p>
    </div>
    <div class="info-card">
      <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
      <h3>Address</h3>
      <p>Dar es Salaam, Tanzania</p>
    </div>
    <div class="info-card">
      <div class="info-icon"><i class="fas fa-clock"></i></div>
      <h3>Hours</h3>
      <p>Reception: 24/7</p>
    </div>
  </div>

  <!-- CONTACT FORM -->
  <div class="contact-form-wrap">
    <h2>Send Us a Message</h2>

    <?php if (isset($_GET['success'])) { ?>
      <p style="color:green; text-align:center;"><?php echo $_GET['success']; ?></p>
    <?php } ?>
    <?php if (isset($_GET['error'])) { ?>
      <p style="color:red; text-align:center;"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <form id="contactForm">
      <div class="form-group">
        <label>Your Name</label>
        <input type="text" id="cName" placeholder="e.g. John Doe" required>
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" id="cEmail" placeholder="e.g. john@email.com" required>
      </div>
      <div class="form-group">
        <label>Subject</label>
        <input type="text" id="cSubject" placeholder="e.g. Room Inquiry" required>
      </div>
      <div class="form-group">
        <label>Message</label>
        <textarea id="cMessage" rows="5" placeholder="Write your message here..." required></textarea>
      </div>
      <button class="btn-send" type="submit">Send via WhatsApp</button>
    </form>
  </div>

</section>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const name = document.getElementById('cName').value.trim();
  const email = document.getElementById('cEmail').value.trim();
  const subject = document.getElementById('cSubject').value.trim();
  const message = document.getElementById('cMessage').value.trim();
  if (!name || !email || !subject || !message) { alert('Please fill in all fields.'); return; }
  const text = encodeURIComponent('*New Inquiry from Hotel De Mag Website*\n\nName: ' + name + '\nEmail: ' + email + '\nSubject: ' + subject + '\nMessage: ' + message);
  window.open('https://wa.me/255764966568?text=' + text, '_blank');
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
