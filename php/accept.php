<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'worker') {
    header('Location: ../index.html');
}
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the values of the form fields
    $r_id = $_GET["r_id"];

    // Retrieve the request from the database
    $request = getRequestById($link, $r_id);
    if ($request != -1) {
        // Calculate the total price of the sale
        //$total_price = $request['s_qty'] * $request['price'];

        // Get the values for the sales table
        $stk_id = $request['stk_id'];
        $c_id = $request['c_id'];
        $w_id = $_SESSION['w_id'];
        $s_qty = $request['s_qty'];
        $prescription = $request['prescription'];
        $dollar_rate = $request['dollar_rate'];
        $total_price=$request['total_price'];

        $prescription = base64_encode($prescription);

        // Insert the sale into the database
        $query = "INSERT INTO sales (stk_id, c_id, w_id, s_qty, total_price, prescription, dollar_rate)
          VALUES ('$stk_id', '$c_id', '$w_id', '$s_qty', '$total_price', '$prescription', '$dollar_rate')";

        if (mysqli_query($link, $query)) {
            // Update the stock quantity in the stock table
            $stk_id = $request['stk_id'];
            $s_qty = $request['s_qty'];
            $updateQuery = "UPDATE stock SET qty = qty - $s_qty, sold = sold + 1 WHERE stk_id = $stk_id";
            if (mysqli_query($link, $updateQuery)) {
                // Delete the row from the requests table
                $query = "DELETE FROM requests WHERE r_id = '$r_id'";
                if (mysqli_query($link, $query)) {
                    http_response_code(200);
                    echo "OK";
                    header('Location: ../worker.php');//not working
                } else {
                    echo "Error deleting record: " . mysqli_error($link);
                }
            } else {
                echo "Error updating record: " . mysqli_error($link);
            }
        } else {
            echo "Error inserting record: " . mysqli_error($link);
        }
    } else {
        echo "No requests found.";
    }
}
function getRequestById($link, $r_id)
{
    $query = "SELECT * FROM requests WHERE requests.r_id ='$r_id' LIMIT 1";
    $result = mysqli_query($link, $query);
    if ($result && mysqli_num_rows($result) == 1) {
        $request = mysqli_fetch_assoc($result);
        return $request;
    } else {
        return -1; //no requests or multiple requests
    }
}
