<?php
session_start();
include('../condb.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the cinema name from the form
    $cinema_name = trim($_POST['cinema_name']);

    // Prepare the SQL insert statement
    $sql = "INSERT INTO cinemas (cinema_name) VALUES (:cinema_name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cinema_name', $cinema_name);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['success'] = "Cinema added successfully!";
    } else {
        $_SESSION['error'] = "Error adding cinema: " . implode(", ", $stmt->errorInfo());
    }

    // Redirect back to the add cinema page
    header("Location: add_cinema.php");
    exit();
}
?>
