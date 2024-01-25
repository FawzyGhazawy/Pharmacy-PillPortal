<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../login.php');
}
require_once 'connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form values
    $medicine = $_POST["medicine"];
    $type = $_POST["type"];
    $qty = $_POST["qty"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // File upload handling
    if ($_FILES["pic"]["error"] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["pic"]["tmp_name"];
        $pic_data = file_get_contents($tmp_name);
        $pic_data = mysqli_real_escape_string($link, $pic_data);
        $pic_type = $_FILES["pic"]["type"];
        $pic_name = $_FILES["pic"]["name"];
    } else {
        // Handle file upload error
        echo "Error uploading file: " . $_FILES["pic"]["error"];
        exit;
    }

    // Prepare and execute the SQL query
    $query = "INSERT INTO stock (medicine, type, qty, description, price, pic) VALUES ('$medicine', '$type', '$qty', '$description', '$price', '$pic_data')";
    if (mysqli_query($link, $query)) {
        // Success
        echo "Medicine added successfully.";
    } else {
        // Error
        echo "Error: " . mysqli_error($link);
    }
}
