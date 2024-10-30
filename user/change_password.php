<?php
session_start();
if (!isset($_SESSION['user_login'])) {
$_SESSION['error'] = 'กรุณาเขาสูระบบ!';
header('location: ../login.php');
}
include 'header.php';
include 'navbar.php';
include 'sidebar.php';
include 'change_password_dt.php';
include 'footer.php';
?>