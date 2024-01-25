<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'worker') {
    header('Location: index.html');
}
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the values of the form fields
    $r_id = $_GET["r_id"];

    $query = "UPDATE requests SET denied = '1' WHERE requests.r_id ='$r_id'";

    if (mysqli_query($link, $query)) {
        echo "OK";
    } else {
        echo "Error updating record: " . mysqli_error($link);
    }
}
