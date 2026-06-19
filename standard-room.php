<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=Please login first to view rooms');
    exit();
}
include 'db_connect.php';

$room_type = 'Standard';

$rooms = mysqli_query(
    $conn,
    "SELECT * FROM rooms 
     WHERE room_type='$room_type'
     ORDER BY room_id DESC"
);

$room_count = mysqli_num_rows($rooms);

$min_price_result = mysqli_query(
    $conn,
    "SELECT IFNULL(MIN(price),0) AS min_price 
     FROM rooms 
     WHERE room_type='$room_type'
     "
);

$min_price_row = mysqli_fetch_assoc($min_price_result);
$min_price = $min_price_row['min_price'];

function getRoomImage($image, $room_type) {

    if (!empty($image)) {
        return $image;
    }

    switch (strtolower($room_type)) {

        case 'standard':
            return 'images/standard1.png';

        case 'deluxe':
            return 'images/deluxe1.png';

        default:
            return 'images/suite1.png';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script>if (!sessionStorage.getItem('hms_logged_in')) { window.location.href = 'logout.php'; }</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standard Rooms - Hotel De Mag</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/rooms-shared.css">
    <link rel="stylesheet" href="css/standard-room.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<nav class="navbar">

    <a href="index.php" class="logo">
        HOTEL DE MAG
    </a>

    <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">

        <span></span>
        <span></span>
        <span></span>

    </button>

    <ul class="nav-links" id="navLinks">

        <li><a href="index.php">Home</a></li>

        <li><a href="about.php">About</a></li>

        <li><a href="room.php" class="active">Rooms</a></li>

        <li><a href="services.php">Services</a></li>

        <li><a href="contact.php">Contact</a></li>

    </ul>

    <a href="login.php" class="btn-outline">
        Login
    </a>

</nav>

<header class="rooms-header">

    <h1>Standard Rooms</h1>

    <p>
        Cozy, clean and affordable — everything you need for a great stay
    </p>

</header>

<a href="room.php" class="back-link">

    ← Back to All Rooms

</a>

<section class="room-type-section">

    <div class="room-type-label">

        <h2>Standard Rooms</h2>

        <p>

            <?php echo $room_count; ?> available options —

            From TSH <?php echo number_format($min_price, 0); ?>/night

        </p>

    </div>

    <div class="room-gallery">

        <?php if ($room_count === 0) : ?>

            <p class="no-rooms">

                No standard rooms are available at the moment.

            </p>

        <?php else : ?>

            <?php while ($room = mysqli_fetch_assoc($rooms)) : ?>

                <div class="room-card">

                    <div class="room-img-wrap">

                        <img
                            src="<?php echo htmlspecialchars(getRoomImage($room['image'], $room['room_type'])); ?>"
                            alt="<?php echo htmlspecialchars($room['room_name']); ?>"
                        >

                        <span class="price-tag">

                            From TSH <?php echo number_format($room['price'], 0); ?>/night

                        </span>

                    </div>

                    <div class="room-card-info">

                        <h3>

                            <?php echo htmlspecialchars($room['room_name']); ?>

                        </h3>

                        <p>

                            Capacity:

                            <?php echo htmlspecialchars($room['capacity']); ?>

                            guests.

                            Status:

                            <?php echo htmlspecialchars(ucfirst($room['status'])); ?>

                        </p>

                        <div class="room-amenities">

                            <span><i class="fas fa-wifi"></i> WiFi</span>

                            <span><i class="fas fa-snowflake"></i> AC</span>

                            <span><i class="fas fa-tv"></i> TV</span>

                            <span><i class="fas fa-egg"></i> Breakfast</span>

                        </div>

                        <?php if ($room['status'] == 'available') : ?>

    <button
        type="button"
        class="btn-book-card"
        onclick="openModal(
            '<?php echo $room['room_id']; ?>',
            '<?php echo htmlspecialchars($room['room_name'], ENT_QUOTES); ?>',
            '<?php echo $room['price']; ?>'
        )">

        Book This Room

    </button>

<?php else : ?>

    <button
        type="button"
        class="btn-book-card"
        disabled
        style="background: gray; cursor: not-allowed;">

        Already Booked

    </button>

<?php endif; ?>
                    </div>

                </div>

            <?php endwhile; ?>

        <?php endif; ?>

    </div>

</section>

<!-- BOOKING MODAL -->
<div
    class="modal-overlay"
    id="bookingModal"
    onclick="closeModalOutside(event)"
>

    <div class="modal-box">

        <button
            class="modal-close"
            type="button"
            onclick="closeModal()"
        >
            ✕
        </button>

        <h2>Book Your Room</h2>

        <p class="modal-room-name" id="modalRoomName"></p>

        <p class="modal-price" id="modalRoomPrice"></p>

        <form action="booking_process.php" method="POST">

            <input
                type="hidden"
                name="room_id"
                id="roomIdInput"
            >

            <input
                type="hidden"
                name="room_name"
                id="roomNameInput"
            >

            <input
                type="hidden"
                name="price_per_night"
                id="roomPriceInput"
                value="0"
            >

            <div class="form-group">

                <label>Full Name</label>

                <input
                    type="text"
                    name="guest_name"
                    placeholder="e.g. John Doe"
                    required
                >

            </div>

            <div class="form-group">

                <label>Email Address</label>

                <input
                    type="email"
                    name="guest_email"
                    placeholder="e.g. john@email.com"
                    required
                >

            </div>

            <div class="form-row">

                <div class="form-group">

                    <label>Check-in</label>

                    <input
                        type="date"
                        name="check_in"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Check-out</label>

                    <input
                        type="date"
                        name="check_out"
                        required
                    >

                </div>

            </div>

            <div class="form-group">

                <label>Guests</label>

                <select name="guests" required>

                    <option>1 Guest</option>

                </select>

            </div>

            <button class="btn-confirm" type="submit">

                Confirm Booking

            </button>

        </form>

    </div>

</div>

<footer>

    <div class="footer-grid">

        <div class="footer-col">

            <h3>HOTEL DE MAG</h3>

            <p>
                Luxury, comfort, and unforgettable experiences.
            </p>

        </div>

        <div class="footer-col">

            <h3>Quick Links</h3>

            <a href="index.php">Home</a>

            <a href="about.php">About</a>

            <a href="room.php">Rooms</a>

            <a href="contact.php">Contact</a>

        </div>

        <div class="footer-col">

            <h3>Contact</h3>

            <p>hoteldemag@gmail.com</p>

            <p>+255 764 966 568</p>

            <p>Dar es Salaam, Tanzania</p>

        </div>

    </div>

    <div class="footer-bottom">

        <p>© 2026 Hotel De Mag. All rights reserved.</p>

    </div>

</footer>

<script>

function toggleMenu() {

    document
        .getElementById('navLinks')
        .classList.toggle('open');
}

function openModal(roomId, roomName, price) {

    document.getElementById('roomIdInput').value =
        roomId;

    document.getElementById('roomNameInput').value =
        roomName;

    document.getElementById('roomPriceInput').value =
        price;

    document.getElementById('modalRoomName').textContent =
        roomName;

    document.getElementById('modalRoomPrice').textContent =
        'TSH ' + price + '/night';

    document
        .getElementById('bookingModal')
        .classList.add('active');

    document.body.style.overflow = 'hidden';
}

function closeModal() {

    document
        .getElementById('bookingModal')
        .classList.remove('active');

    document.body.style.overflow = '';
}

function closeModalOutside(e) {

    if (e.target.id === 'bookingModal') {

        closeModal();
    }
}

</script>

</body>
</html>