<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'pharmacist') {
    header('Location: index.html');
}
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values of the form fields
    $dollar_rate = $_POST["dollar_rate"];
    $query = "UPDATE dollar_rate SET dollar_rate = '$dollar_rate'";
    if (mysqli_query($link, $query)) {
        http_response_code(200);
        echo "OK";
        header("Location: ../pharmacist.php");
    } else {
        echo "Error inserting record: " . mysqli_error($link);
    }
}