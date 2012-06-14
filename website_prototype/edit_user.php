<?PHP
/*
EDIT.PHP
Allows user to edit specific entry in database
*/

include 'modules/connect_db.php';

if (!isset($_GET['id']) || is_null($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: users.php");
}

$id = $_GET['id'];

$userResult = mysql_query("SELECT * FROM users WHERE id=$id") or die(mysql_error());
$userRow = mysql_fetch_array($userResult);

if (!$userRow) {
	header("Location: users.php");
}

// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($id_, $name_, $email_, $username_, $role_, $error)
{
	include 'modules/header.php';
	echo $username;
?>
	
<p>
	<a href="users.php">Users</a> ->
	Edit User
</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<h1>Edit User</h1>

<form name="user" action="" method="post">
	<input type="text" name="id" value="<?= $id_ ?>" />
	<table>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" maxlength="50" size="50" value="<?= $name_ ?>" /></td>
		</tr>
		<tr>
			<td>e-mail:</td>
			<td><input type="text" name="email" maxlength="50" value="<?= $email_ ?>" /></td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" maxlength="50" value="<?= $username_ ?>" /></td>
		</tr>
		<tr>
			<td>Role:</td>
			<td>
				<select name="role">
					<?PHP
					include 'modules/constants.php';
					foreach($roles as $role1){
						echo "<option value='".$role1."' ";
						if ($role1 == $role_) {
							echo " selected='selected' ";
						}
						echo ">".$role1."</option>";
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

// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['id']))
{
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
	{
		// get form data, making sure it is valid
		$id = $_POST['id'];
		$name = $_POST["name"];
		$email = $_POST["email"];
		$username = $_POST["username"];
		$role = $_POST['role'];
		
		// check that firstname/lastname fields are both filled in
		if ($name == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';
			
			//error, display form
			//renderForm($id, $name, $code, $subject_id, $error);
			renderForm($id, $name, $email, $username, $role, $error);
		}
		else
		{
			// save the data to the database
			mysql_query("UPDATE users SET name='$name', email='$email', username='$username', role='$role' WHERE id='$id'")
			or die(mysql_error());
			
			// once saved, redirect back to the view page
			header("Location: view_user.php?id=".$id);
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
	//$id = $userRow["id"];
	//$name = $userRow["name"];
	//$email = $userRow["email"];
	//$username = $userRow["username"];
	//$role = $userRow['role'];
	renderForm($userRow["id"], $userRow["name"], $userRow["email"], $userRow['username'], $userRow["role"], '');
}
?>