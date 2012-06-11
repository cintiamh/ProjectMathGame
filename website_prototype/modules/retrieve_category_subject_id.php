<?php
if (!isset($_GET['id']) || is_null($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: subjects.php");
}

$category_id = $_GET['id'];

$category_result = mysql_query("SELECT * FROM categories WHERE id=$category_id") or die(mysql_error());

$category_row = mysql_fetch_array($category_result);

// check that the 'id' matches up with a row in the databse
if ($category_row !== FALSE) {
	$subject_id = $category_row['subject_id'];
} 
else {
	header("Location: subjects.php");
}
?>