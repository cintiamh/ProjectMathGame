<?PHP
/*
EDIT.PHP
Allows user to edit specific entry in database
*/

include 'modules/connect_db.php';
include 'modules/retrieve_school_ids.php';

// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($id, $name, $address, $city, $state, $error)
{
include 'modules/header.php';
?>

<p>
	<a href="schools.php">Schools</a> ->
	Edit School
</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<h1>Edit Option</h1>

<form name="school" action="" method="post">
	<input type="hidden" name="id" value="<?= $id ?>" />
	<table>
		<tr>
			<td>Name:</td>
			<td>
				<input type="text" name="name" maxlength="100" size="50" value="<?= $name ?>" />
			</td>
		</tr>
		<tr>
			<td>Address:</td>
			<td>
				<input type="text" name="address" maxlength="255" size="50" value="<?= $address ?>" />
			</td>
		</tr>
		<tr>
			<td>City:</td>
			<td>
				<input type="text" name="city" maxlength="50" size="30" value="<?= $city ?>" />
			</td>
		</tr>
		<tr>
			<td>State:</td>
			<td>
				<input type="text" name="state" maxlength="2" size="3" value="<?= $state ?>" />
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
		$name = $_POST["name"];
		$address = $_POST["address"];
		$city = $_POST["city"];
		$state = $_POST['state'];
		
		// check that firstname/lastname fields are both filled in
		if ($name == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';
			
			//error, display form
			//renderForm($id, $name, $code, $subject_id, $error);
			renderForm($id, $name, $address, $city, $state, $error);
		}
		else
		{
			// save the data to the database
			mysql_query("UPDATE schools SET name='$name', address='$address', city='$city', state='$state' WHERE id='$id'")
			or die(mysql_error());
			
			// once saved, redirect back to the view page
			header("Location: view_school.php?id=".$id);
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
	$id = $schoolRow["id"];
	$name = $schoolRow["name"];
	$address = $schoolRow["address"];
	$city = $schoolRow["city"];
	$state = $schoolRow['state'];
	renderForm($id, $name, $address, $city, $state, '');
}
?>