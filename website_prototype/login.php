<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

include "modules/user_validation.php";

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($in_username, $error)
{
	include 'modules/header.php';
?>

<h1>Sign in</h1>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<form name="login" action="" method="post">
	<table>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" value="<?= $in_username ?>" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Login" /></td>
		</tr>
	</table>
</form>

<?PHP
	include 'modules/footer.php';
}

// connect to the database
include('modules/connect_db.php');

// check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['username']))
{
	// get form data, making sure it is valid
	$fusername = mysql_real_escape_string(htmlspecialchars($_POST['username']));
	$fpassword = mysql_real_escape_string(htmlspecialchars($_POST['password']));
	
	// check to make sure both fields are entered
	if ($fusername == '')
	{
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';

		// if either field is blank, display the form again
		renderForm($fusername, $error);
	}
	else
	{
		$result = mysql_query("SELECT * FROM users WHERE username='$fusername'");

		if (mysql_num_rows($result) <= 0) {
			$error = "This username doesn't exist.";
			renderForm('', $error);
		}

		$userData = mysql_fetch_array($result, MYSQL_ASSOC);

		// Hashing
		$hash = hash('sha256', $fpassword);
		$salt = $userData['salt'];
		$hash = hash('sha256', $salt . $hash);
		
		if ($hash != $userData['password']) {
			//header('Location: login_form.php');
			$error = 'ERROR: Incorrect password.';

			// if either field is blank, display the form again
			renderForm($fusername, $error);
		}
		else {
			validateUser($userData['id'], $userData['username'], $userData['role']);
			//echo $userData['id'];
			//print_r($userData);
		}
		
		if (!isLoggedIn()) {
			//header('Location: login_form.php');
			$error = 'ERROR: You are not logged in.';

			// if either field is blank, display the form again
			renderForm($fusername, $error);
		}
		else {
			header('Location: index.php');
			//die('Logged in successfully.');
		}
	}
}
else
// if the form hasn't been submitted, display the form
{
	renderForm('', '');
}
?>