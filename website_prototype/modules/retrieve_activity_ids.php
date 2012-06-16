<?php

// Verifies the user's id is valid
if (!isset($_GET['id']) || is_null($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: users.php");
}

$id = $_GET['id'];

$activityResult = mysql_query("SELECT * FROM activities WHERE id=$id") or die(mysql_error());
$activityRow = mysql_fetch_array($activityResult);

if (!$activityRow) {
	header("Location: users.php");
} 

?>