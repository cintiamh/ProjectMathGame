<?PHP
include 'modules/header.php';
?>

<h1>Sign in</h1>

<form name="login" action="login.php" method="post">
	<table>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" /></td>
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
?>