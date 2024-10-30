<?php
session_start(); // It's fine to keep this as it is since it's the entry point

// Check for user login
if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: ../login.php');
    exit(); // Stop further execution
}

// Include necessary files
include 'header.php';
include 'navbar.php';
include 'sidebar.php';
include 'reserve_form.php';
include 'footer.php';
?>
