<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($name, $address, $city, $state, $error)
{
	include 'modules/header.php';
?>

<p>
	<a href="schools.php">Schools</a> -> 
	New School
</p>
<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<h1>New School</h1>
<form name="school" action="" method="post">
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

// connect to the database
include('modules/connect_db.php');

// check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['name']))
{
	// get form data, making sure it is valid
	$name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
	$address = mysql_real_escape_string(htmlspecialchars($_POST['address']));
	$city = mysql_real_escape_string(htmlspecialchars($_POST['city']));
	$state = mysql_real_escape_string(htmlspecialchars($_POST['state']));

	// check to make sure both fields are entered
	if ($name == '')
	{
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';

		// if either field is blank, display the form again
		renderForm($name, $address, $city, $state, $error);
	}
	else
	{
		// save the data to the database
		mysql_query("INSERT schools SET name='$name', address='$address', city='$city', state='$state'")
		or die(mysql_error());

		// once saved, redirect back to the view page
		$last_id = mysql_insert_id();
		//header("Location: schools.php");
		header("Location: view_school.php?id=$last_id");
	}
}
else
// if the form hasn't been submitted, display the form
{
	renderForm($name, $address, $city, $state, $error);
}
?>

