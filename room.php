<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=Please login first to view rooms');
    exit();
}
include 'db_connect.php';

$room_types = [
  'Standard' => [
    'title' => 'Standard Rooms',
    'description' => 'Cozy, clean and affordable — everything you need for a comfortable stay.',
    'buttonClass' => 'standard-btn',
    'link' => 'standard-room.php',
    'image' => 'images/standard1.png',
  ],
  'Deluxe' => [
    'title' => 'Deluxe Rooms',
    'description' => 'Premium comfort with stunning views, elegant design and exclusive amenities.',
    'buttonClass' => 'deluxe-btn',
    'link' => 'deluxe-room.php',
    'image' => 'images/deluxe1.png',
  ],
  'Suite' => [
    'title' => 'Executive Suites',
    'description' => 'The pinnacle of luxury — spacious suites with butler service and panoramic views.',
    'buttonClass' => 'suite-btn',
    'link' => 'executive-suite.php',
    'image' => 'images/suite2.png',
  ],
];

foreach ($room_types as $type => $meta) {
    $summary = mysqli_query($conn, "SELECT COUNT(*) AS count, IFNULL(MIN(price),0) AS min_price FROM rooms WHERE room_type='$type'");
    $summary = mysqli_fetch_assoc($summary);
    $room_types[$type]['count'] = $summary['count'];
    $room_types[$type]['min_price'] = $summary['min_price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rooms - Hotel De Mag</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/room.css">
  <script>if (!sessionStorage.getItem('hms_logged_in')) { window.location.href = 'logout.php'; }</script>
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
    <li><a href="room.php" class="active">Rooms</a></li>
    <li><a href="services.php">Services</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
  <a href="login.php" class="btn-outline">Login</a>
</nav>

<header class="rooms-landing-header">
  <h1>Our Rooms</h1>
  <p>Choose your perfect room type and explore what's waiting for you</p>
</header>

<section class="room-types-grid">
  <?php foreach ($room_types as $type => $meta) : ?>
    <div class="type-card">
      <div class="type-img">
        <img src="<?php echo htmlspecialchars($meta['image']); ?>" alt="<?php echo htmlspecialchars($meta['title']); ?>">
        <div class="type-overlay"></div>
      </div>
      <div class="type-info">
        <span class="type-badge"><?php echo $meta['count'] > 0 ? $meta['count'].' Room Options' : 'No rooms available'; ?></span>
        <h2><?php echo $meta['title']; ?></h2>
        <p><?php echo $meta['description']; ?></p>
        <div class="type-price">From <strong>TSH <?php echo number_format($meta['min_price'], 0); ?></strong>/night</div>
        <a href="<?php echo $meta['link']; ?>" class="type-btn <?php echo $meta['buttonClass']; ?>">View <?php echo $meta['title']; ?> →</a>
      </div>
    </div>
  <?php endforeach; ?>
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
