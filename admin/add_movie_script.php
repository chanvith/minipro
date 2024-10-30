<?php
// ตรวจสอบว่าเซสชันเริ่มต้นแล้วหรือยัง
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../condb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เก็บข้อมูลจากฟอร์ม
    $movie_name = trim($_POST['movie_name']);
    $director = trim($_POST['director']);
    $release_year = (int)$_POST['release_year'];
    $genre = trim($_POST['genre']);
    $cinema_id = (int)$_POST['cinema_id']; // รับค่า cinema_id จากฟอร์ม

    // ตรวจสอบข้อมูลที่ได้รับ
    if (empty($movie_name) || empty($director) || empty($release_year) || empty($genre) || empty($cinema_id)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
        header("Location: add_movies.php");
        exit();
    }

    // จัดการการอัปโหลดไฟล์
    $poster = null;

    if (!empty($_FILES['poster']['name'])) {
        // ตรวจสอบข้อผิดพลาดในการอัปโหลด
        if ($_FILES['poster']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์โปสเตอร์: " . $_FILES['poster']['error'];
            header("Location: add_movies.php");
            exit();
        }

        // ตรวจสอบขนาดไฟล์
        if ($_FILES['poster']['size'] > 2 * 1024 * 1024) { // 2MB
            $_SESSION['error'] = "ไฟล์โปสเตอร์ต้องมีขนาดไม่เกิน 2MB.";
            header("Location: add_movies.php");
            exit();
        }

        $targetDir = realpath(__DIR__ . "/../assets/dist/posters/") . "/";
        $fileName = basename($_FILES['poster']['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = uniqid() . '_' . time() . '.' . $fileType;
        $targetFilePath = $targetDir . $newFileName;

        // ตรวจสอบประเภทไฟล์ที่อนุญาต
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // ย้ายไฟล์ที่อัปโหลดไปยังไดเรกทอรีเป้าหมาย
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetFilePath)) {
                $poster = $newFileName;
            } else {
                $_SESSION['error'] = "เกิดข้อผิดพลาดในการย้ายไฟล์โปสเตอร์.";
                header("Location: add_movies.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "ประเภทไฟล์ไม่ถูกต้อง อนุญาตเฉพาะ JPG, JPEG, PNG & GIF เท่านั้น.";
            header("Location: add_movies.php");
            exit();
        }
    }

    // แทรกข้อมูลลงในตาราง movies
    $sql = "INSERT INTO movies (movie_name, director, release_year, genre, poster, cinema_id) VALUES (?, ?, ?, ?, ?, ?)"; // เพิ่ม cinema_id ใน SQL
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $movie_name);
    $stmt->bindParam(2, $director);
    $stmt->bindParam(3, $release_year);
    $stmt->bindParam(4, $genre);
    $stmt->bindParam(5, $poster);
    $stmt->bindParam(6, $cinema_id); // Bind cinema_id

    // ตรวจสอบการดำเนินการ
    if ($stmt->execute()) {
        $_SESSION['success'] = "เพิ่มภาพยนตร์เรียบร้อยแล้ว!";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการเพิ่มภาพยนตร์: " . implode(", ", $stmt->errorInfo());
    }

    // เปลี่ยนเส้นทางกลับไปที่ฟอร์ม
    header("Location: add_movies.php");
    exit();
}
?>
