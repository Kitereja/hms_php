<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $token = bin2hex(random_bytes(32));

        $update = "UPDATE users SET reset_token='$token', reset_token_expiry=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email='$email'";
        mysqli_query($conn, $update);

        header("Location: reset_password.php?token=$token");
        exit();
    } else {
        header("Location: forgot_password.php?error=Email not found in our system");
        exit();
    }
}
?>
