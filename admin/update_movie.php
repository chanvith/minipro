<?php
session_start();
require_once '../condb.php'; // Connect to your database

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the movie details from the form
    $movie_id = $_POST['movie_id'];
    $movie_name = $_POST['movie_name'];
    $director = $_POST['director'];
    $release_year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $cinema_id = $_POST['cinema_id'];

    // Initialize a variable for the poster
    $poster = $_FILES['poster']['name'];

    // Handle file upload if a new poster is provided
    if (!empty($poster)) {
        $target_dir = '../assets/posters/'; // Set your target directory
        $target_file = $target_dir . basename($poster);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES['poster']['tmp_name']);
        if ($check === false) {
            $_SESSION['error'] = 'ไฟล์ที่อัปโหลดไม่ใช่ภาพ!';
            $uploadOk = 0;
        }

        // Check file size (limit to 5MB)
        if ($_FILES['poster']['size'] > 5000000) {
            $_SESSION['error'] = 'ไฟล์ภาพใหญ่เกินไป!';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $_SESSION['error'] = 'ไฟล์ภาพต้องเป็น JPG, JPEG, PNG หรือ GIF!';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk === 0) {
            header('location: edit_movie.php?movie_id=' . $movie_id);
            exit();
        } else {
            // If everything is ok, upload the file
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
                // Successfully uploaded the new poster
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปโหลดภาพโปสเตอร์!';
                header('location: edit_movie.php?movie_id=' . $movie_id);
                exit();
            }
        }
    } else {
        // If no new poster is uploaded, retain the existing poster in the database
        $poster = null; // or set it to the existing poster if you want to keep it
    }

    // Prepare the SQL update statement
    $sql = "UPDATE movies SET movie_name = ?, director = ?, release_year = ?, genre = ?, cinema_id = ?" . 
           ($poster ? ", poster = ?" : "") . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    if ($poster) {
        $stmt->bindParam(1, $movie_name);
        $stmt->bindParam(2, $director);
        $stmt->bindParam(3, $release_year);
        $stmt->bindParam(4, $genre);
        $stmt->bindParam(5, $cinema_id);
        $stmt->bindParam(6, $poster);
        $stmt->bindParam(7, $movie_id);
    } else {
        $stmt->bindParam(1, $movie_name);
        $stmt->bindParam(2, $director);
        $stmt->bindParam(3, $release_year);
        $stmt->bindParam(4, $genre);
        $stmt->bindParam(5, $cinema_id);
        $stmt->bindParam(6, $movie_id);
    }

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['success'] = 'ปรับปรุงข้อมูลภาพยนตร์สำเร็จ!';
    } else {
        $_SESSION['error'] = 'ไม่สามารถปรับปรุงข้อมูลภาพยนตร์ได้!';
    }

    // Redirect to the movie list or edit page
    header('location: movie_list.php');
    exit();
} else {
    $_SESSION['error'] = 'ข้อมูลที่ส่งไม่ถูกต้อง!';
    header('location: movie_list.php');
    exit();
}
?>
