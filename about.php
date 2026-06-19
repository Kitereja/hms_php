<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About - Hotel De Mag</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/about.css">
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
    <li><a href="about.php" class="active">About</a></li>
    <li><a href="room.php">Rooms</a></li>
    <li><a href="services.php">Services</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
  <a href="login.php" class="btn-outline">Login</a>
</nav>

<!-- HEADER -->
<header class="about-header">
  <h1>About Hotel De Mag</h1>
  <p>Luxury, comfort, and unforgettable experiences since 2020</p>
</header>

<!-- ABOUT CARDS -->
<section class="about-container">

  <div class="about-card">
    <div class="card-icon"><i class="fas fa-hotel"></i></div>
    <h2>Who We Are</h2>
    <p>
      Hotel De Mag is a premium hotel offering world-class hospitality,
      modern rooms, and exceptional customer service. We are dedicated to
      making every guest feel at home.
    </p>
  </div>

  <div class="about-card">
    <div class="card-icon"><i class="fas fa-bullseye"></i></div>
    <h2>Our Mission</h2>
    <p>
      To provide guests with comfort, relaxation, and luxury at affordable
      prices while ensuring a memorable stay experience that keeps you
      coming back.
    </p>
  </div>

  <div class="about-card">
    <div class="card-icon"><i class="fas fa-check-circle"></i></div>
    <h2>Why Choose Us</h2>
    <p>
      ✔ Luxury rooms &amp; suites<br>
      ✔ 24/7 customer service<br>
      ✔ Free WiFi &amp; breakfast<br>
      ✔ Prime Dar es Salaam location<br>
      ✔ Swimming pool &amp; spa
    </p>
  </div>

</section>

<!-- STATS STRIP -->
<section class="stats-strip">
  <div class="stat">
    <h3>500+</h3>
    <p>Happy Guests Monthly</p>
  </div>
  <div class="stat">
    <h3>3</h3>
    <p>Room Categories</p>
  </div>
  <div class="stat">
    <h3>6+</h3>
    <p>Amenities & Services</p>
  </div>
  <div class="stat">
    <h3>4.9★</h3>
    <p>Average Guest Rating</p>
  </div>
</section>

<!-- TEAM / VALUES -->
<section class="values-section">
  <h2>Our Values</h2>
  <div class="values-grid">
    <div class="value-item">
      <span><i class="fas fa-handshake"></i></span>
      <h4>Integrity</h4>
      <p>We are honest and transparent with every guest, always.</p>
    </div>
    <div class="value-item">
      <span><i class="fas fa-gem"></i></span>
      <h4>Excellence</h4>
      <p>We hold ourselves to the highest standards in everything we do.</p>
    </div>
    <div class="value-item">
      <span><i class="fas fa-heart"></i></span>
      <h4>Hospitality</h4>
      <p>Warm, genuine care for every single guest who walks through our doors.</p>
    </div>
    <div class="value-item">
      <span><i class="fas fa-globe-africa"></i></span>
      <h4>Community</h4>
      <p>Proud to serve and invest in our local Dar es Salaam community.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="about-cta">
  <h2>Ready to Experience Hotel De Mag?</h2>
  <p>Book your stay today and discover luxury redefined.</p>
  <a href="room.php" class="btn-gold">Book a Room</a>
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
