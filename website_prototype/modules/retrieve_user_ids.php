<?php

if (!isset($_GET['id']) || is_null($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: users.php");
}

$id = $_GET['id'];

$userResult = mysql_query("SELECT * FROM users WHERE id=$id") or die(mysql_error());
$userRow = mysql_fetch_array($userResult);

if (!$userRow) {
	header("Location: users.php");
}

?>