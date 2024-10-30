<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: ../login.php');
}


include 'header.php';
include 'navbar.php';
include 'sidebar.php';
include 'main_content.php';
include 'footer.php';
