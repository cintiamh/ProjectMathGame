<?PHP
/*
EDIT.PHP
Allows user to edit specific entry in database
*/

include 'modules/user_validation.php';

// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($id, $name, $code, $subject_id, $error)
{
include 'modules/header.php';
?>

<p>
	<a href="subjects.php">Subjects</a> -> 
	<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
	Edit Category
</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<h1>Edit Category</h1>

<form name="category" action="" method="post">
	<input type="hidden" name="id" value="<?php echo $id; ?>"/>
	<input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>"/>
	<table>
		<tr>
			<td>Name/Title:</td>
			<td><input type="text" name="name" maxlength="50" size="50" value="<?= $name ?>" /></td>
		</tr>
		<tr>
			<td>Code:</td>
			<td><input type="text" name="code" maxlength="50" value="<?= $code ?>" /></td>
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
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
	{
		// get form data, making sure it is valid
		$id = $_POST['id'];
		$subject_id = $_POST['subject_id'];
		$name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
		$code = mysql_real_escape_string(htmlspecialchars($_POST['code']));
		
		// check that firstname/lastname fields are both filled in
		if ($name == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';
			
			//error, display form
			renderForm($id, $name, $code, $subject_id, $error);
		}
		else
		{
			// save the data to the database
			mysql_query("UPDATE categories SET name='$name', code='$code', subject_id='$subject_id' WHERE id='$id'")
			or die(mysql_error());
			
			// once saved, redirect back to the view page
			header("Location: view_category.php?subject_id=$subject_id&category_id=".$id);
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
	if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
	{
		// query db
		$id = $_GET['id'];
		$result = mysql_query("SELECT * FROM categories WHERE id=$id")
		or die(mysql_error());
		$row = mysql_fetch_array($result);
		
		// check that the 'id' matches up with a row in the databse
		if($row)
		{
			// get data from db
			$name = $row['name'];
			$code = $row['code'];
			$subject_id = $row['subject_id'];
			
			// show form
			renderForm($id, $name, $code, $subject_id, '');
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