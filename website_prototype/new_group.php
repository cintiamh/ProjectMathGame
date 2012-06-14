<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

include 'modules/connect_db.php';
include 'modules/retrieve_school_ids.php';

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($grade, $code, $school_id, $error)
{
	include 'modules/header.php';
?>

<p>
	<a href="schools.php">Schools</a> ->
	<a href="view_school.php?id=<?= $id ?>">View School</a> -> 
	New Group
</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<h1>New Group</h1>
<form name="group" action="" method="post">
	<input type="hidden" name="school_id" value="<?= $school_id ?>" />
	<table>
		<tr>
			<td>Grade:</td>
			<td>
				<input type="number" name="grade" value="<?= $grade ?>" />
			</td>
		</tr>
		<tr>
			<td>Code:</td>
			<td>
				<input type="text" name="code" maxlength="50" size="30" value="<?= $code ?>" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" value="Submit" />
			</td>
		</tr>
	</table>
</form>

<?PHP
	include 'modules/footer.php';
}
// check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['grade']))
{
	// get form data, making sure it is valid
	$grade = $_POST['grade'];
	$code = $_POST['code'];
	$school_id = $_POST['school_id'];

	// check to make sure both fields are entered
	if ($grade == '')
	{
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';

		// if either field is blank, display the form again
		renderForm($grade, $code, $school_id, $error);
	}
	else
	{
		// save the data to the database
		mysql_query("INSERT groups SET grade='$grade', code='$code', school_id='$school_id'")
		or die(mysql_error());

		//header("Location: schools.php");
		header("Location: view_school.php?id=$school_id");
	}
}
else
// if the form hasn't been submitted, display the form
{
	renderForm('', '', $id, '');
}
?>

