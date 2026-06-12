<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT email FROM users WHERE reset_token='$token' AND reset_token_expiry > NOW() LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) != 1) {
        header("Location: reset_password.php?token=$token&error=Invalid or expired token");
        exit();
    }

    if ($password != $confirm_password) {
        header("Location: reset_password.php?token=$token&error=Passwords do not match");
        exit();
    }

    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        header("Location: reset_password.php?token=$token&error=Password must contain uppercase, lowercase, number, and special character");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];

    $update = "UPDATE users SET password='$hashed_password', reset_token=NULL, reset_token_expiry=NULL WHERE email='$email'";
    if (mysqli_query($conn, $update)) {
        header("Location: login.php?success=Password reset successful. Please login with your new password");
    } else {
        header("Location: reset_password.php?token=$token&error=Something went wrong. Please try again");
    }
}
?>
