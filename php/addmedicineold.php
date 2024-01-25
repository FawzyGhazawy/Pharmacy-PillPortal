<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../login.php');
}
require_once 'connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set and not empty
    if (
        isset($_POST['medicine']) && !empty($_POST['medicine']) &&
        isset($_POST['type']) && !empty($_POST['type']) &&
        isset($_POST['qty']) && !empty($_POST['qty']) &&
        isset($_POST['description']) && !empty($_POST['description']) &&
        isset($_POST['price']) && !empty($_POST['price'])
    ) {

        // Retrieve the form data
        $medicine = $_POST['medicine'];
        $type = $_POST['type'];
        $qty = $_POST['qty'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Database connection
        require_once 'connection.php';

        // File upload handling
        if (isset($_FILES['pic']) && !empty($_FILES['pic']['tmp_name'])) {
            $pic = $_FILES['pic']['tmp_name'];

            // Read the uploaded file content
            $picData = file_get_contents($pic);

            // Prepare the INSERT statement with the file data
            $query = "INSERT INTO stock (medicine, type, qty, description, price, pic) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, "ssidsb", $medicine, $type, $qty, $description, $price, $picData);
        } else {
            // Prepare the INSERT statement without the file data
            $query = "INSERT INTO stock (medicine, type, qty, description, price) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, "ssids", $medicine, $type, $qty, $description, $price);
        }

        // Execute the INSERT statement
        if (mysqli_stmt_execute($stmt)) {
            // Success message
            echo "Medicine added successfully.";
        } else {
            // Error message
            echo "Error adding medicine: " . mysqli_error($link);
        }

        // Close the statement and database connection
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    } else {
        // Required fields are missing
        echo "All fields are required.";
    }
}
