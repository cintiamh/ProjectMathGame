<?php
/*
 DELETE.PHP
 Deletes a specific entry from the 'players' table
 */

 include 'modules/user_validation.php';
 
// connect to the database
include ('modules/connect_db.php');
// retrieves and checks question_id, category_id, and subject_id
include 'modules/retrieve_option_ids.php';

$deleteResult = mysql_query("DELETE FROM options WHERE id=$id") or die(mysql_error());
header("Location: view_question.php?id=$question_id");
?>