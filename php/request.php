<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'client') {
    header('Location: index.html');
}
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values of the form fields
    $qty = $_POST["qty"];
    $stk_id = $_POST["stk_id"];
    $c_id = $_POST["c_id"];
    $price = $_POST['price'];
    //$image_data = 0;
    $rate = 1500;

    // File upload handling
    if ($_FILES["prescription"]["error"] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["prescription"]["tmp_name"];
        $prescription_data = file_get_contents($tmp_name);
        $prescription_data = mysqli_real_escape_string($link, $prescription_data);
        $prescription_type = $_FILES["prescription"]["type"];
        $prescription_name = $_FILES["prescription"]["name"];
    } else {
        $query = "SELECT dollar_rate FROM dollar_rate";
        $result = mysqli_query($link, $query);
        if (($result) && (mysqli_num_rows($result) > 0)) {
            $row = mysqli_fetch_assoc($result);
            $rate = $row['dollar_rate'];
        }
        $tot = $qty * $price;
        $totll = $tot * $rate;
        // Prepare and execute the SQL query
        $query = "INSERT INTO requests (stk_id, c_id, s_qty, total_price, total_price_ll, dollar_rate) 
         VALUES ('$stk_id', '$c_id', '$qty', '$tot', '$totll','$rate') ";
    
        if (mysqli_query($link, $query)) {
            http_response_code(200);
            echo "OK";
            header("Location: ../buynew.php?stk_id=$stk_id");
        } else {
            echo "Error inserting record: " . mysqli_error($link);
        }
    
        exit;
    }

    $query = "SELECT dollar_rate FROM dollar_rate";
    $result = mysqli_query($link, $query);
    if (($result) && (mysqli_num_rows($result) > 0)) {
        $row = mysqli_fetch_assoc($result);
        $rate = $row['dollar_rate'];
    }
    $tot = $qty * $price;
    $totll = $tot * $rate;
    // Prepare and execute the SQL query
    $query = "INSERT INTO requests (stk_id, c_id, s_qty, total_price, total_price_ll, prescription, dollar_rate) 
     VALUES ('$stk_id', '$c_id', '$qty', '$tot', '$totll','$prescription_data','$rate') ";

    if (mysqli_query($link, $query)) {
        http_response_code(200);
        echo "OK";
        header("Location: ../buynew.php?stk_id=$stk_id");
    } else {
        echo "Error inserting record: " . mysqli_error($link);
    }

}

