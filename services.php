<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services - Hotel De Mag</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/services.css">
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
    <li><a href="services.php" class="active">Services</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
  <a href="login.php" class="btn-outline">Login</a>
</nav>

<!-- HEADER -->
<header class="services-header">
  <h1>Our Services</h1>
  <p>Everything you need for a perfect, comfortable stay</p>
</header>

<!-- SERVICES GRID -->
<section class="services-section">
  <div class="services-grid">

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-swimmer"></i></div>
      <h3>Swimming Pool</h3>
      <p>Relax and refresh in our outdoor swimming pool, open from 6 AM to 10 PM daily. Perfect for morning laps or an afternoon swim.</p>
    </div>

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-spa"></i></div>
      <h3>Spa & Wellness</h3>
      <p>Unwind with our professional spa treatments including massages, facials, and body wraps. Book in advance for guaranteed slots.</p>
    </div>

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-dumbbell"></i></div>
      <h3>Fitness Gym</h3>
      <p>Stay on top of your fitness routine with our fully-equipped gym, available 24/7 for all guests during their stay.</p>
    </div>

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-utensils"></i></div>
      <h3>Restaurant</h3>
      <p>Enjoy local and international cuisine at our in-house restaurant. Breakfast is included; lunch and dinner available daily.</p>
    </div>

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-wifi"></i></div>
      <h3>Free High-Speed WiFi</h3>
      <p>Stay connected throughout the hotel with complimentary high-speed internet access in all rooms and common areas.</p>
    </div>

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-plane"></i></div>
      <h3>Airport Shuttle</h3>
      <p>We offer convenient airport pick-up and drop-off services. Please request at least 24 hours in advance at reception.</p>
    </div>

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-car"></i></div>
      <h3>Free Parking</h3>
      <p>Complimentary secure parking is available for all hotel guests throughout the duration of your stay.</p>
    </div>

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-bell"></i></div>
      <h3>24/7 Room Service</h3>
      <p>Order food, drinks, or request any amenities at any hour. Our room service team is always ready to assist you.</p>
    </div>

    <div class="service-card">
      <div class="svc-icon"><i class="fas fa-baby"></i></div>
      <h3>Childcare Services</h3>
      <p>Travel with peace of mind — our professional childcare service is available to look after your little ones while you relax.</p>
    </div>

  </div>
</section>

<!-- CTA -->
<section class="services-cta">
  <h2>Ready to Experience It All?</h2>
  <p>Book your stay today and enjoy all our services included.</p>
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
