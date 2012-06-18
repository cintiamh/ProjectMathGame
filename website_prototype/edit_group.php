<?PHP
/*
EDIT.PHP
Allows user to edit specific entry in database
*/

include 'modules/user_validation.php';
include 'modules/connect_db.php';
include 'modules/retrieve_group_ids.php';

// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($id, $grade, $code, $school_id, $error)
{
include 'modules/header.php';
?>

<p>
	<a href="schools.php">Schools</a> ->
	<a href="view_school.php?id=<?= $school_id ?>">View School</a> -> 
	Edit Group
</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<h1>Edit Group</h1>
<form name="group" action="" method="post">
	<input type="hidden" name="id" value="<?= $id ?>" />
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

// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['id']))
{
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
	{
		// get form data, making sure it is valid
		$id = $_POST['id'];
		$grade = $_POST['grade'];
		$code = $_POST['code'];
		$school_id = $_POST['school_id'];
		
		// check that firstname/lastname fields are both filled in
		if ($grade == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';
			
			//error, display form
			//renderForm($id, $name, $code, $subject_id, $error);
			renderForm($id, $grade, $code, $school_id, $error);
		}
		else
		{
			// save the data to the database
			mysql_query("UPDATE groups SET grade='$grade', code='$code', school_id='$school_id' WHERE id='$id'")
			or die(mysql_error());
			
			// once saved, redirect back to the view page
			header("Location: view_school.php?id=".$school_id);
		}
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
	$id = $groupRow['id'];
	$grade = $groupRow['grade'];
	$code = $groupRow['code'];
	$school_id = $groupRow['school_id'];
	renderForm($id, $grade, $code, $school_id, $error);
}
?>