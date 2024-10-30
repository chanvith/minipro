<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Movie</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Include your CSS file here -->
</head>
<body>
<?php 
require_once '../condb.php'; 
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Add New Movie</h1>
        </div>
    </section>
    <section class="content">
        <div class="card card-outline card-info">
            <div class="card-body">
                <!-- Display messages if available -->
                <?php
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                } elseif (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }
                ?>

                <!-- Form for Adding Movie -->
                <form action="add_movie_script.php" method="post" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
                    <div class="mb-3">
                        <label for="movie_name" class="form-label">Movie Name</label>
                        <input type="text" class="form-control" name="movie_name" id="movie_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="director" class="form-label">Director</label>
                        <input type="text" class="form-control" name="director" id="director" required>
                    </div>
                    <div class="mb-3">
                        <label for="release_year" class="form-label">Release Year</label>
                        <input type="number" class="form-control" name="release_year" id="release_year" required>
                    </div>
                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre</label>
                        <input type="text" class="form-control" name="genre" id="genre">
                    </div>
                    <div class="mb-3">
                        <label for="cinema_id" class="form-label">Select Cinema</label>
                        <select name="cinema_id" id="cinema_id" class="form-control" required>
                            <option value="">-- Select Cinema --</option>
                            <?php
                            // ดึงข้อมูลโรงภาพยนตร์จากฐานข้อมูล
                            $sql = "SELECT id, cinema_name FROM cinemas";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['id'] . '">' . $row['cinema_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="poster" class="form-label">Movie Poster</label>
                        <input type="file" class="form-control" name="poster" id="poster" accept=".jpg,.jpeg,.png,.gif" required> <!-- File input for the poster -->
                    </div>
                    <button type="submit" class="btn btn-primary">Add Movie</button>
                </form>
            </div>
        </div>
    </section>
</div>
</body>
</html>
