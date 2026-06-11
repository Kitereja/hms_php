<?php
session_start();
include 'db_connect.php';

$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if ($password == $user['password'] || password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            $redirect = $user['role'] == 'admin' ? 'admin.php' : 'index.php';

            if ($is_ajax) {
                echo json_encode(['success' => true, 'redirect' => $redirect]);
                exit();
            }
            header("Location: $redirect");
            exit();

        } else {
            if ($is_ajax) {
                echo json_encode(['success' => false, 'error' => 'Wrong password']);
                exit();
            }
            header("Location: login.php?error=Wrong password");
            exit();
        }

    } else {
        if ($is_ajax) {
            echo json_encode(['success' => false, 'error' => 'User not found']);
            exit();
        }
        header("Location: login.php?error=User not found");
        exit();
    }
}
?>