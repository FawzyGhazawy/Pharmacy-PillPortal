<?php
require_once('connection.php');

function getstock($link)
{
	$query = "SELECT * FROM stock";
	$result = mysqli_query($link, $query);
	$stock = [];
	if (($result) && (mysqli_num_rows($result) > 0)) {
		$i = 0;
		while ($row = mysqli_fetch_assoc($result)) {
			$stock[0][$i] = $row['stk_id'];
			$stock[1][$i] = $row['medicine'];
			$stock[2][$i] = $row['type'];
			$stock[3][$i] = $row['qty'];
			$stock[4][$i] = $row['description'];
			$stock[5][$i] = $row['price'];
			$stock[6][$i] = $row['pic'];

			++$i;
		}
	}
	return $stock;
}

function getstock2($link, $stk_id)
{
	$query = "SELECT * FROM stock WHERE stk_id='$stk_id'";
	$result = mysqli_query($link, $query);
	$stock = [];
	if (($result) && (mysqli_num_rows($result) > 0)) {
		if ($row = mysqli_fetch_assoc($result)) {
			$stock = $row;
			return $stock;
		}
		return -1;
	}
	return -1;
}

function getstock3($link, $stk_id)
{
	$query = "SELECT * FROM stock WHERE stk_id='$stk_id'";
	$result = mysqli_query($link, $query);
	$stock = [];
	if (($result) && (mysqli_num_rows($result) > 0)) {

		while ($row = mysqli_fetch_assoc($result)) {
			$stock[0] = $row['stk_id'];
			$stock[1] = $row['medicine'];
			$stock[2] = $row['type'];
			$stock[3] = $row['qty'];
			$stock[4] = $row['description'];
			$stock[5] = $row['price'];
			$stock[6] = $row['pic'];
		}
	}
	return $stock;
}
