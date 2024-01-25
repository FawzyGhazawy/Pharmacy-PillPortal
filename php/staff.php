<?php
require_once 'connection.php';
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
	header('Location: login.html');
}

function getEmpByUsername($link, $username)
{
	$query = "SELECT u_id FROM users WHERE username='$username'";
	if($result = mysqli_query($link, $query)){
	$row = mysqli_fetch_assoc($result);
	$u_id = $row['u_id'];
	return $u_id;
	}else{
		return -1;
	}
}

function getEmpById($link, $w_id)
{
	$query = "SELECT name FROM workers WHERE w_id='$w_id'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);
	$emp = $row['name'];
	return $emp;
}