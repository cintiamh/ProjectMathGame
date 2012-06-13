<?php
if (!isset($_GET['id']) || is_null($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: schools.php");
}

$id = $_GET['id'];

$groupResult = mysql_query("SELECT * FROM groups WHERE id=$id") or die(mysql_error());
$groupRow = mysql_fetch_array($groupResult);

if (!$groupRow) {
	header("Location: schools.php");
}

$school_id = $groupRow['school_id'];

$schoolResult = mysql_query("SELECT * FROM schools WHERE id=$school_id") or die(mysql_error());
$schoolRow = mysql_fetch_array($schoolResult);

if (!$schoolRow) {
	header("Location: schools.php");
}
