<?php
session_start();
include '../condb.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_id = $_POST['movie_id'];

    // ลบข้อมูลภาพยนตร์จากฐานข้อมูล
    $delete_sql = "DELETE FROM movies WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bindParam(1, $movie_id);

    if ($delete_stmt->execute()) {
        $_SESSION['success'] = 'ลบข้อมูลภาพยนตร์เรียบร้อยแล้ว!';
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการลบข้อมูล!';
    }
    header('location: movie_list.php'); // เปลี่ยนไปที่หน้ารายการภาพยนตร์
    exit;
}
