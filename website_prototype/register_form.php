<?PHP
include 'modules/header.php';
?>

<h1>Register</h1>

<form name="register" action="register.php" method="post">
	
	<table>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" maxlength="50" size="50" /></td>
		</tr>
		<tr>
			<td>e-mail:</td>
			<td><input type="text" name="email" maxlength="50" /></td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" maxlength="50" /></td>
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
						echo "<option value='".$role."'>".$role."</option>";
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
?>
