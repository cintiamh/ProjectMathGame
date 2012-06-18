<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

include "modules/user_validation.php";

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($in_name, $in_email, $in_username, $in_role, $error)
{
	include 'modules/header.php';
?>

<h1>Register</h1>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<form name="register" action="" method="post">
	
	<table>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" maxlength="50" size="50" value="<?= $in_name ?>" /></td>
		</tr>
		<tr>
			<td>e-mail:</td>
			<td><input type="text" name="email" maxlength="50" value="<?= $in_email ?>" /></td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" maxlength="50" value="<?= $in_username ?>" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pass1" /></td>
		</tr>
		<tr>
			<td>Confirm Password:</td>
			<td><input type="password" name="pass2" /></td>
		</tr>
		<tr>
			<td>Role:</td>
			<td>
				<select name="role">
					<?PHP
					include 'modules/constants.php';
					foreach($roles as $role){
						echo "<option value='".$role."'";
						if ($role == $in_role) {
							echo " selected='selected' ";
						}
						echo ">".$role."</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Register" /></td>
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
	$fname = mysql_real_escape_string(htmlspecialchars($_POST['name']));
	$femail = mysql_real_escape_string(htmlspecialchars($_POST['email']));
	$fusername = mysql_real_escape_string(htmlspecialchars($_POST['username']));
	$frole = mysql_real_escape_string(htmlspecialchars($_POST['role']));
	$fpass1 = mysql_real_escape_string(htmlspecialchars($_POST['pass1']));
	$fpass2 = mysql_real_escape_string(htmlspecialchars($_POST['pass2']));
	
	if ($fusername != '') {
		$result = mysql_query("SELECT * FROM users WHERE username='$fusername'");

		if (mysql_num_rows($result) > 0) {
			$error = "This username has already been taken. Please select another username.";
			renderForm($fname, $femail, '', $frole, $error);
		}	
	}
	
	// check to make sure both fields are entered
	if ($fname == '' || $femail == '' || $fusername == '' || $fpass1 == '' || $fpass2 == '')
	{
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';

		// if either field is blank, display the form again
		renderForm($fname, $femail, $fusername, $frole, $error);
	}
	else if ($fpass1 != $fpass2) {
		
		// generate error message
		$error = 'ERROR: The password confirmation is not matching.';

		// if either field is blank, display the form again
		renderForm($fname, $femail, $fusername, $frole, $error);
	}
	else
	{
		// Hashing
		$hash = hash('sha256', $fpass1);
		
		// create a 3 character sequence
		function createSalt() {
			$string = md5(uniqid(rand(), true));
			return substr($string, 0, 3);
		}
		
		$salt = createSalt();
		$hash = hash('sha256', $salt . $hash);
		
		$query = "INSERT INTO users (name, email, username, password, salt, role) VALUES ('".$fname."', '".$femail."', '".$fusername."', '".$hash."', '".$salt."', '".$frole."');";
		$result = mysql_query($query) or die(mysql_error());

		// once saved, redirect back to the view page
		header("Location: login.php");
	}
}
else
// if the form hasn't been submitted, display the form
{
	renderForm('', '', '', '', '');
}
?>

