<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "hotel_de_mag";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

include 'room_status_auto.php';
