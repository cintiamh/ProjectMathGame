<?php
/*
 DELETE.PHP
 Deletes a specific entry from the 'players' table
 */

 include 'modules/user_validation.php';
 
if (!isRoleAdmin()) {
	header("Location: index.php");
}

if (!isRoleTeacher()) {
	header("Location: index.php");
}

// connect to the database
include ('modules/connect_db.php');
// retrieves and checks question_id, category_id, and subject_id
include 'modules/retrieve_school_ids.php';

$deleteResult = mysql_query("DELETE FROM schools WHERE id=$id") or die(mysql_error());
header("Location: schools.php");
?>