<?php
session_start();


if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: ../login.php');
}


include 'header.php';
include 'navbar.php';
include 'sidebar.php';
include 'register_act_dt.php';
include 'footer.php';