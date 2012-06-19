<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

include 'modules/user_validation.php';

if (!isRoleAdmin()) {
	header("Location: index.php");
}

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($name, $code, $error)
{
	include 'modules/header.php';
	?>

	<p>
		<a href="subjects.php">Subjects</a> -> New Subject
	</p>
	
	<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
	?>
	
	<h1>New Subject</h1>
	
	<form name="subject" action="" method="post">
		
		<table>
			<tr>
				<td>Name/Title:</td>
				<td><input type="text" name="name" maxlength="100" size="50" value="<?= $name ?>" /></td>
			</tr>
			<tr>
				<td>Code:</td>
				<td><input type="text" name="code" maxlength="30" value="<?= $code ?>" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Submit" /></td>
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
		$code = mysql_real_escape_string(htmlspecialchars($_POST['code']));
	
		// check to make sure both fields are entered
		if ($name == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';
		
			// if either field is blank, display the form again
			renderForm($name, $code, $error);
		}
		else
		{
			// save the data to the database
			mysql_query("INSERT subjects SET name='$name', code='$code'")
			or die(mysql_error());
		
			// once saved, redirect back to the view page
			header("Location: subjects.php");
		}
	}
	else
	// if the form hasn't been submitted, display the form
	{
		renderForm('','','');
	}
?> 


