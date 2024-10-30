<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_movie";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "เชื่อมต่อฐานข้อมูลสําเร็จ";
} catch (PDOException $e) {
    echo "การเชื่อมต่อฐานข้อมูลผิดพลาด: " . $e->getMessage();
}
