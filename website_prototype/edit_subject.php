<?PHP
/*
EDIT.PHP
Allows user to edit specific entry in database
*/

// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($id, $name, $code, $error)
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

<h1>Edit Subject</h1>

<form name="subject" action="" method="post">
	<input type="hidden" name="id" value="<?php echo $id; ?>"/>
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

// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['id']))
{
	echo "post version";
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
	{
		// get form data, making sure it is valid
		$id = $_POST['id'];
		$name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
		$code = mysql_real_escape_string(htmlspecialchars($_POST['code']));
		
		// check that firstname/lastname fields are both filled in
		if ($name == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';
			
			//error, display form
			renderForm($id, $name, $code, $error);
		}
		else
		{
			// save the data to the database
			mysql_query("UPDATE subjects SET name='$name', code='$code' WHERE id='$id'")
			or die(mysql_error());
			
			// once saved, redirect back to the view page
			header("Location: view_subject.php?subject_id=".$id);
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
	
	// get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
	if (isset($_GET['subject_id']) && is_numeric($_GET['subject_id']) && $_GET['subject_id'] > 0)
	{
		// query db
		$id = $_GET['subject_id'];
		$result = mysql_query("SELECT * FROM subjects WHERE id=$id")
		or die(mysql_error());
		$row = mysql_fetch_array($result);
		
		// check that the 'id' matches up with a row in the databse
		if($row)
		{
			
			// get data from db
			$name = $row['name'];
			$code = $row['code'];
			
			// show form
			renderForm($id, $name, $code, '');
		}
		else
		// if no match, display result
		{
			echo "No results!";
		}
	}
	else
	// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
	{
		echo 'Error!';
	}
}
?>