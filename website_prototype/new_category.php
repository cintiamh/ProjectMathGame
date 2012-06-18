<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

include 'modules/user_validation.php';

function getSubjectIdValue() {
	
}

//include 'modules/connect_db.php';

//$query = "SELECT * FROM subjects WHERE id = '$subject_id';";
//$result = mysql_query($query);
		
//if (mysql_num_rows($result) < 1) {
//	header('Location: subjects.php');
//}

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($name, $code, $error)
{
	if (!isset($_GET['subject_id']) || is_null($_GET['subject_id']) || !is_numeric($_GET['subject_id'])) {
		header("Location: subjects.php");
	}
	
	$subject_id = $_GET['subject_id'];
	
	include 'modules/header.php';
	?>
	<p>
		<a href="subjects.php">Subjects</a> -> 
		<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
		New Category
	</p>
	
	<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
	?>
	
	<h1>New Category</h1>
	
	<form name="category" action="" method="post">
		
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
				<td><input type="hidden" name="subject_id" value="<?= $subject_id ?>" /></td>
				<td><input type="submit" value="Register" /></td>
			</tr>
		</table>
	</form>
	
	<?PHP
	include 'modules/footer.php';
}

// check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['name'])) {
	
	// connect to the database
	include('modules/connect_db.php');
	
	// get form data, making sure it is valid
	$name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
	$code = mysql_real_escape_string(htmlspecialchars($_POST['code']));
	$subject_id = mysql_real_escape_string(htmlspecialchars($_POST['subject_id']));

	// check to make sure both fields are entered
	if ($name == '') {
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';
		// if either field is blank, display the form again
		renderForm($name, $code, $error);
	} else {
		// save the data to the database
		$insert_query = "INSERT categories SET name='$name', code='$code', subject_id='$subject_id'"; 
		mysql_query($insert_query) or die(mysql_error());

		// once saved, redirect back to the view page
		header("Location: view_subject.php?subject_id=" . $subject_id);
	}
} else
// if the form hasn't been submitted, display the form
{
	renderForm('', '', '');
}
?> 
