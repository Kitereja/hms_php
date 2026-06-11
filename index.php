<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel De Mag</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- HERO -->
<header class="hero" id="home">
  <div class="overlay"></div>
  <!-- NAVBAR -->
  <nav class="navbar">
    <a href="index.php" class="logo">HOTEL DE MAG</a>
    <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
    <ul class="nav-links" id="navLinks">
      <li><a href="index.php" class="active">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="room.php">Rooms</a></li>
      <li><a href="services.php">Services</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
    <a href="login.php" class="btn-outline">Login</a>
  </nav>

  <!-- HERO CONTENT -->
  <div class="hero-content">

    <p class="subtitle">Modern Luxury and Timeless Living</p>

    <h1>
      Welcome to Our Luxurious<br>
      Hotel
    </h1>

    <p class="description">
      At Hotel De Mag, we provide a perfect blend of luxury, comfort,
      and world-class service to make every stay unforgettable.
    </p>

  </div>

</header>

<!-- WHY CHOOSE US -->
<section class="features-section">

  <h2>Why Choose Us</h2>

  <div class="features-grid">

    <div class="feature-card">
      <div class="feature-icon">🛏️</div>
      <h3>Luxury Rooms</h3>
      <p>Elegantly designed rooms with premium furnishings and modern amenities.</p>
    </div>

    <div class="feature-card">
      <div class="feature-icon">🍳</div>
      <h3>Free Breakfast</h3>
      <p>Start your day right with our complimentary full breakfast every morning.</p>
    </div>

    <div class="feature-card">
      <div class="feature-icon">📶</div>
      <h3>Free WiFi</h3>
      <p>High-speed internet throughout the hotel — stay connected always.</p>
    </div>

    <div class="feature-card">
      <div class="feature-icon">🔔</div>
      <h3>24/7 Service</h3>
      <p>Our staff is available around the clock to meet your every need.</p>
    </div>

  </div>

</section>

<!-- ROOM SEARCH -->
<section class="rooms-preview">

  <h2>Search Your Room</h2>

  <p class="section-sub">
    Choose the room type that matches your comfort, budget, and number of guests.
  </p>

  <div class="room-search-box">

    <select id="roomSearch">

      <option value="">-- Select Room Type --</option>

      <option value="standard-room.php">
        Standard Room - Affordable and comfortable
      </option>

      <option value="deluxe-room.php">
        Deluxe Room - More comfort and space
      </option>

      <option value="executive-suite.php">
        Executive Suite - Luxury and bigger space
      </option>

    </select>

    <button onclick="searchRoom()" class="btn-gold-sm">
      Search Room
    </button>

  </div>

</section>

<!-- SERVICES -->
<section id="services" class="services-strip">

  <h2>Our Services</h2>

  <p class="section-sub">
    Everything you need for a perfect stay
  </p>

  <div class="services-icons">

    <div class="svc">🏊 Swimming Pool</div>
    <div class="svc">💆 Spa & Wellness</div>
    <div class="svc">🏋️ Fitness Gym</div>
    <div class="svc">🍽️ Restaurant</div>
    <div class="svc">🚗 Free Parking</div>
    <div class="svc">✈️ Airport Shuttle</div>

  </div>

  <a href="services.php" class="btn-gold">
    All Services
  </a>

</section>

<!-- TESTIMONIALS -->
<section class="testimonials">

  <h2>What Our Guests Say</h2>

  <div class="testi-grid">

    <div class="testi-card">
      <p>
        "Absolutely stunning hotel. The staff was incredibly welcoming and the rooms were spotless. Will definitely return!"
      </p>
      <strong>— Amina K., Dar es Salaam</strong>
      <div class="stars">★★★★★</div>
    </div>

    <div class="testi-card">
      <p>
        "Best hotel experience I've had. The breakfast was amazing and the bed was so comfortable. Highly recommend Hotel De Mag."
      </p>
      <strong>— James M., Nairobi</strong>
      <div class="stars">★★★★★</div>
    </div>

    <div class="testi-card">
      <p>
        "Prime location, friendly staff and excellent value for money. The executive suite exceeded all my expectations."
      </p>
      <strong>— Sarah T., London</strong>
      <div class="stars">★★★★★</div>
    </div>

  </div>

</section>

<!-- ABOUT STRIP MOVED TO BOTTOM -->
<section id="about" class="about-strip">

  <div class="about-strip-inner">

    <h2>About Hotel De Mag</h2>

    <p>
      Hotel De Mag offers a unique blend of modern luxury and timeless comfort.
      Our mission is to provide exceptional hospitality and create memorable
      experiences for every guest. Located in a prime location, we are your
      home away from home.
    </p>

    <a href="about.php" class="btn-gold">
      Discover More
    </a>

  </div>

</section>

<!-- CONTACT -->
<section id="contact" class="contact-strip">

  <h2>Get In Touch</h2>

  <p>
    📧 hoteldemag@gmail.com &nbsp;|&nbsp; 📞 +255 764 966 568
  </p>

  <a href="contact.php" class="btn-gold" style="margin-top:20px; display:inline-block;">
    Contact Page
  </a>

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
function searchRoom() {
  const room = document.getElementById('roomSearch').value;
  if (room === "") { alert("Please select a room type"); return; }
  window.location.href = room;
}
</script>

</body>
</html>