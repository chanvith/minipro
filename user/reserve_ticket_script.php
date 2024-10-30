<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../condb.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $movie_id = (int)$_POST['movie_id']; // เปลี่ยนจาก showtime_id เป็น movie_id
    $seat_id = (int)$_POST['seat_id'];

    // Check if data is not empty
    if (!empty($movie_id) && !empty($seat_id)) {
        // ตรวจสอบว่า movie_id มีอยู่ในตาราง movies หรือไม่
        $checkMovie = $conn->prepare("SELECT COUNT(*) FROM movies WHERE id = ?");
        $checkMovie->bindParam(1, $movie_id);
        $checkMovie->execute();
        
        if ($checkMovie->fetchColumn() == 0) {
            $_SESSION['error'] = "ไม่พบ Movie ID นี้ในระบบ กรุณาตรวจสอบ.";
            header("Location: reserve_ticket.php");
            exit();
        }

        // Insert data into reservations table (user_id = NULL)
        $sql = "INSERT INTO reservations (movie_id, seat_id) VALUES (?, ?)"; // ไม่มี user_id
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $movie_id); // ใช้ movie_id
        $stmt->bindParam(2, $seat_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "การจองสำเร็จ!";
        } else {
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการจอง กรุณาลองอีกครั้ง.";
        }
    } else {
        $_SESSION['error'] = "ข้อมูลการจองไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง.";
    }

    // Redirect back to the reservation form
    header("Location: reserve_ticket.php");
    exit();
}
?>
