<?php
session_start();
require_once '../condb.php'; // Connect to your database

// Check if movie_id is provided in the URL
if (!isset($_GET['movie_id'])) {
    $_SESSION['error'] = 'ไม่พบรหัสภาพยนตร์!';
    header('location: movie_list.php');
    exit();
}

// Fetch the movie details based on the provided movie_id
$movie_id = $_GET['movie_id'];
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $movie_id);
$stmt->execute();
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the movie exists
if (!$movie) {
    $_SESSION['error'] = 'ไม่พบภาพยนตร์ในระบบ!';
    header('location: movie_list.php');
    exit();
}

// Fetch the list of cinemas
$sql = "SELECT * FROM cinemas"; // Assuming you have a cinemas table
$stmt = $conn->prepare($sql);
$stmt->execute();
$cinemas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include header and navigation
include 'header.php';
include 'navbar.php';
include 'sidebar.php';
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>แก้ไขข้อมูลภาพยนตร์</h1>
        </div>
    </section>
    <section class="content">
        <div class="card card-outline card-info">
            <div class="card-body">
                <!-- Display success or error messages -->
                <?php
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                } elseif (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }
                ?>

                <!-- Edit Movie Form -->
                <form action="update_movie.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie['id']); ?>">
                    
                    <div class="form-group">
                        <label for="movie_name">ชื่อภาพยนตร์</label>
                        <input type="text" class="form-control" name="movie_name" id="movie_name" 
                               value="<?php echo htmlspecialchars($movie['movie_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="director">ผู้กำกับ</label>
                        <input type="text" class="form-control" name="director" id="director" 
                               value="<?php echo htmlspecialchars($movie['director']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="release_year">ปีที่ออกฉาย</label>
                        <input type="number" class="form-control" name="release_year" id="release_year" 
                               value="<?php echo htmlspecialchars($movie['release_year']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="genre">ประเภท</label>
                        <input type="text" class="form-control" name="genre" id="genre" 
                               value="<?php echo htmlspecialchars($movie['genre']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="cinema_id">เลือกโรงภาพยนตร์</label>
                        <select class="form-control" name="cinema_id" id="cinema_id" required>
                            <option value="">เลือกโรงภาพยนตร์</option>
                            <?php foreach ($cinemas as $cinema): ?>
                                <option value="<?php echo $cinema['id']; ?>" 
                                    <?php echo ($movie['cinema_id'] == $cinema['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cinema['cinema_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="poster">โปสเตอร์ภาพยนตร์</label>
                        <input type="file" class="form-control" name="poster" id="poster" accept="image/*">
                        <small>อัปโหลดภาพโปสเตอร์ใหม่ถ้าต้องการ</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                    <a href="movie_list.php" class="btn btn-secondary">ยกเลิก</a>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
include 'footer.php';
?>
