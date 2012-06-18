<?php
/*
 DELETE.PHP
 Deletes a specific entry from the 'players' table
 */

 include 'modules/user_validation.php';
 
// connect to the database
include ('modules/connect_db.php');
include "modules/retrieve_user_ids.php";

$deleteResult = mysql_query("DELETE FROM users WHERE id=$id") or die(mysql_error());
header("Location: users.php");
?>