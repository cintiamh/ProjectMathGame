<?php
include "connect_db.php";

if (isset($_GET['subject_id']) && !is_null($_GET['subject_id']) && is_numeric($_GET['subject_id'])) {

	$subject_id = $_GET['subject_id'];

	$subjectResult = mysql_query("SELECT * FROM subjects WHERE id=$subject_id") or die(mysql_error());
	$subjectRow = mysql_fetch_array($subjectResult);
	
	if ($subjectRow) {
		$result = mysql_query("SELECT * FROM categories WHERE subject_id=$subject_id");
		echo "[,";
		while ($row = mysql_fetch_array($result)) {
			echo '{"optionValue": '.$row["id"].', "optionDisplay": "'.$row["name"].'"}';
		}
		echo "]";
	}
}

// Verifies the category's id is valid
if (!isset($_GET['category_id']) || is_null($_GET['category_id']) || !is_numeric($_GET['category_id'])) {
	//header("Location: users.php");
}
else {
	$category_id = $_GET['category_id'];

	$categoryResult = mysql_query("SELECT * FROM categories WHERE id=$category_id") or die(mysql_error());
	$categoryRow = mysql_fetch_array($categoryResult);
	
	if (!$categoryRow) {
		header("Location: users.php");
	}
}

// Verifies the category's id is valid
if (!isset($_GET['question_id']) || is_null($_GET['question_id']) || !is_numeric($_GET['question_id'])) {
	//header("Location: users.php");
}
else {
	$question_id = $_GET['question_id'];

	$questionResult = mysql_query("SELECT * FROM questions WHERE id=$question_id") or die(mysql_error());
	$questionRow = mysql_fetch_array($questionResult);
	
	if (!$questionRow) {
		header("Location: users.php");
	}
}


/*if ($_GET['id'] == 1) {
  echo <<<HERE_DOC
    [ {"optionValue": 0, "optionDisplay": "Mark"}, {"optionValue":1, "optionDisplay": "Andy"}, {"optionValue":2, "optionDisplay": "Richard"}]
HERE_DOC;
} else if ($_GET['id'] == 2) {
  echo <<<HERE_DOC
    [{"optionValue":10, "optionDisplay": "Remy"}, {"optionValue":11, "optionDisplay": "Arif"}, {"optionValue":12, "optionDisplay": "JC"}]
HERE_DOC;
} else if ($_GET['id'] == 3) {
  echo <<<HERE_DOC
    [{"optionValue":20, "optionDisplay": "Aidan"}, {"optionValue":21, "optionDisplay":"Russell"}]
HERE_DOC;
}*/
?>