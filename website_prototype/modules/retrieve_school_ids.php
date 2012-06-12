<?php
if (!isset($_GET['id']) || is_null($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: schools.php");
}

$id = $_GET['id'];

$schoolResult = mysql_query("SELECT * FROM schools WHERE id=$id") or die(mysql_error());
$schoolRow = mysql_fetch_array($schoolResult);

if (!$schoolRow) {
	header("Location: schools.php");
}
