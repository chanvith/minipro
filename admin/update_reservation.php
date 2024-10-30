<?php
session_start();
include '../condb.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบการส่งข้อมูลฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $seat_id = $_POST['seat_id'];

    // อัปเดตข้อมูลที่นั่งในฐานข้อมูล
    $sql = "UPDATE reservations SET seat_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$seat_id, $reservation_id])) {
        $_SESSION['success'] = 'อัปเดตการจองเรียบร้อยแล้ว!';
        header('location: reservations_list.php'); // เปลี่ยนไปยังหน้ารายการการจอง
        exit;
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปเดต!';
    }
}

// กรณีไม่เข้าถึงได้ถูกต้อง
header('location: reservations_list.php');
exit;
?>
