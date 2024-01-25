<?php
require_once 'connection.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
}

function viewsales($link) {
    $query = "SELECT * FROM sales NATURAL JOIN clients NATURAL JOIN stock ";
    $result = mysqli_query($link, $query);
    
    if (($result) && (mysqli_num_rows($result) > 0)) {
        $sales = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $sales;
    } else {
        return -1; //no sales
    }
}

function viewsalesclient($link,$c_id) {
    $query = "SELECT * FROM sales NATURAL JOIN clients NATURAL JOIN stock WHERE c_id='$c_id'
    ";
    $result = mysqli_query($link, $query);
    
    if (($result) && (mysqli_num_rows($result) > 0)) {
        $sales = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $sales;
    } else {
        return -1; //no sales
    }
}
