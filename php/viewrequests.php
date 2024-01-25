<?php
require_once 'connection.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // extract($_POST);
    // $send_id=$_SESSION['w_id'];

    // $query = "INSERT INTO requests('u_id', 'receive_id', 'message') VALUES ('$send_id','$receive_id','$message')";

    // if (mysqli_query($link, $query)) {
    //     echo "OK";
    // } else {
    //     echo "Error: " . mysqli_error($link);
    // }
}


function viewRequests($link)
{
    $query = "SELECT * FROM requests NATURAL JOIN clients NATURAL JOIN stock WHERE denied='0'";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $requests = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $request = [];
            $request['r_id'] = $row['r_id'];
            $request['stk_id'] = $row['stk_id'];
            $request['medicine'] = $row['medicine'];
            $request['c_name'] = $row['c_id'];
            $request['c_name'] = $row['c_name'];
            $request['s_qty'] = $row['s_qty'];
            $request['total_price'] = $row['total_price'];
            $request['total_price_ll'] = $row['total_price_ll'];
            $request['prescription'] = $row['prescription'];
            $request['dollar_rate'] = $row['dollar_rate'];
            $request['denied'] = $row['denied'];
            $request['timestamp'] = $row['timestamp'];

            $requests[] = $request;
        }

        return $requests;
    } else {
        return -1; // No requests
    }
}

function viewrequestsclient($link, $c_id)
{
    $query = "SELECT * FROM requests NATURAL JOIN clients NATURAL JOIN stock WHERE c_id='$c_id'
    ";
    $result = mysqli_query($link, $query);

    if (($result) && (mysqli_num_rows($result) > 0)) {
        $requests = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $request = [];
            $request['r_id'] = $row['r_id'];
            $request['stk_id'] = $row['stk_id'];
            $request['medicine'] = $row['medicine'];
            $request['c_name'] = $row['c_id'];
            $request['c_name'] = $row['c_name'];
            $request['s_qty'] = $row['s_qty'];
            $request['total_price'] = $row['total_price'];
            $request['total_price_ll'] = $row['total_price_ll'];
            $request['prescription'] = $row['prescription'];
            $request['dollar_rate'] = $row['dollar_rate'];
            $request['denied'] = $row['denied'];
            $request['timestamp'] = $row['timestamp'];

            $requests[] = $request;
        }

        return $requests;
    } else {
        return -1; //no sales
    }
}
