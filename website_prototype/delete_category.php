<?php
/*
 DELETE.PHP
 Deletes a specific entry from the 'players' table
 */

// connect to the database
include ('modules/connect_db.php');

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	// get id value
	$id = $_GET['id'];
	$result = mysql_query("SELECT * FROM categories WHERE id=$id") or die(mysql_error());
	$row = mysql_fetch_array($result);

	// check that the 'id' matches up with a row in the databse
	if ($row) {
		// get data from db
		$subject_id = $row['subject_id'];
	} else
	// if no match, display result
	{
		echo "No results!";
	}

	// delete the entry
	$result = mysql_query("DELETE FROM categories WHERE id=$id") or die(mysql_error());

	// redirect back to the view page
	header("Location: view_subject.php?subject_id=$subject_id");
} else
// if id isn't set, or isn't valid, redirect back to view page
{
	header("Location: subjects.php");
}
?>