<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Ticket</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Include your CSS file here -->
</head>
<body>
<?php 
require_once '../condb.php'; 

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>จองตั๋วหนัง</h1>
        </div>
    </section>
    <section class="content">
        <div class="card card-outline card-info">
            <div class="card-body">
                <!-- Show success or error messages -->
                <?php
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                } elseif (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }
                ?>

                <!-- Form for ticket reservation -->
                <form action="reserve_ticket_script.php" method="post">
                    <div class="mb-3">
                        <label for="movie_id" class="form-label">Movie ID</label>
                        <input type="number" class="form-control" name="movie_id" id="movie_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="seat_id" class="form-label">Seat ID</label>
                        <input type="number" class="form-control" name="seat_id" id="seat_id" required>
                    </div>
                    <button type="submit" class="btn btn-primary">จองตั๋ว</button>
                </form>
            </div>
        </div>
    </section>
</div>
</body>
</html>
