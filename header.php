<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle ?? 'Hotel De Mag'; ?></title>
  <link rel="stylesheet" href="css/global.css">
  <?php if (isset($pageCss)): ?>
    <?php foreach ((array)$pageCss as $css): ?>
      <link rel="stylesheet" href="css/<?php echo $css; ?>">
    <?php endforeach; ?>
  <?php endif; ?>
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="logo">HOTEL DE MAG</a>
  <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
  <ul class="nav-links" id="navLinks">
    <li><a href="index.php" class="<?php echo $activePage == 'home' ? 'active' : ''; ?>">Home</a></li>
    <li><a href="about.php" class="<?php echo $activePage == 'about' ? 'active' : ''; ?>">About</a></li>
    <li><a href="room.php" class="<?php echo $activePage == 'rooms' ? 'active' : ''; ?>">Rooms</a></li>
    <li><a href="services.php" class="<?php echo $activePage == 'services' ? 'active' : ''; ?>">Services</a></li>
    <li><a href="contact.php" class="<?php echo $activePage == 'contact' ? 'active' : ''; ?>">Contact</a></li>
  </ul>
  <a href="login.php" class="btn-outline">Login</a>
</nav>
