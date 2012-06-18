<?PHP
/*
EDIT.PHP
Allows user to edit specific entry in database
*/

include 'modules/user_validation.php';
include 'modules/connect_db.php';
include 'modules/retrieve_activity_ids.php';

// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($id, $success, $start_time, $end_time, $user_id, $question_id, $error)
{
include 'modules/header.php';
?>

	<p>
		<a href="users.php">Users</a> -> 
		<a href="view_user.php?id=<?= $user_id ?>">View User</a> ->
		Finish Activity
	</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>
<h1>Finish Activity</h1>
	
	<form name="question" action="" method="post">
		<input type="hidden" name="id" value="<?= $id ?>" />
		<input type="hidden" name="question_id" value="<?= $question_id ?>" />
		<input type="hidden" name="user_id" value="<?= $user_id ?>" />
		<p>
			Question: 
		<?
		$activityResult = mysql_query("SELECT * FROM activities WHERE id=$id") or die(mysql_error());
		$activityRow = mysql_fetch_array($activityResult);
		
		$questId = $activityRow["question_id"];
	
		$questionResult = mysql_query("SELECT * FROM questions WHERE id=$questId") or die(mysql_error());
		$questionRow = mysql_fetch_array($questionResult);
		
		echo $questionRow['question'];
		?>
		</p>
		
		<p>
			<input type="checkbox" name="success" value="success" <?php if ($success) echo "checked" ?>/> Active
		</p>
		<p>
			<input type="submit" value="Finish Activity" />
		</p>
	</form>

<?PHP
include 'modules/footer.php';
}

// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['id']))
{
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
	{
		// get form data, making sure it is valid
		$id = $_POST['id'];
		$question_id = $_POST['question_id'];
		$user_id = $_POST['user_id'];
		$success = $_POST['success'];
		
		// save the data to the database
		mysql_query("UPDATE activities SET success='$success', end_time=NOW() WHERE id='$id'")
		or die(mysql_error());
		
		// once saved, redirect back to the view page
		header("Location: view_user.php?id=".$user_id);
	}
	else
	{
		// if the 'id' isn't valid, display an error
		echo 'Error!';
	}
}
else
// if the form hasn't been submitted, get the data from the db and display the form
{
	renderForm($id, $activityRow["success"], $activityRow['start_time'], $activityRow["end_time"], $activityRow["user_id"], $activityRow["question_id"], "");
}
?>