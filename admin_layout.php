<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header('Location: login.php?error=Please login as admin first'); exit(); }
$current_page = basename($_SERVER['PHP_SELF']);
function activePage($page, $current_page) { return $page == $current_page ? 'active' : ''; }
?>
