<?php
session_start(); // Start session for flash messages

// Check if the user is logged in
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!'; // "Please log in!"
    header('location: ../login.php');
    exit(); // Exit to prevent further execution
}

include('../condb.php'); // Include your database connection file
include 'header.php'; // Include your header file
include 'navbar.php'; // Include your navbar file
include 'sidebar.php'; // Include your sidebar file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Cinema</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Include your CSS file here -->
</head>
<body>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Add New Cinema</h1>
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

                    <!-- Form for Adding Cinema -->
                    <form action="add_cinema_script.php" method="post">
                        <div class="mb-3">
                            <label for="cinema_name" class="form-label">Cinema Name</label>
                            <input type="text" class="form-control" name="cinema_name" id="cinema_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Cinema</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; // Include your footer file ?>
</body>
</html>
