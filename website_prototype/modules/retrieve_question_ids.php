<?php
if (!isset($_GET['id']) || is_null($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: subjects.php");
}

$question_id = $_GET['id'];
$questionResult = mysql_query("SELECT * FROM questions WHERE id=$question_id") or die(mysql_error());
$questionRow = mysql_fetch_array($questionResult);

// check that the 'id' matches up with a row in the databse
if ($questionRow !== FALSE) {
	$category_id = $questionRow['category_id'];
} 
else {
	header("Location: subjects.php");
}

if (is_null($category_id) || !is_numeric($category_id)) {
	header("Location: subjects.php");
}

$categoryResult = mysql_query("SELECT * FROM categories WHERE id=$category_id") or die(mysql_error());
$categoryRow = mysql_fetch_array($categoryResult);

// check that the 'id' matches up with a row in the databse
if ($categoryRow !== FALSE) {
	$subject_id = $categoryRow['subject_id'];
} 
else {
	header("Location: subjects.php");
}

if (is_null($subject_id) || !is_numeric($subject_id)) {
	header("Location: subjects.php");
}
?>