<?php

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

include 'modules/header.php';
?>

<p>
	<a href="users.php">Users</a> ->
	View User
</p>

<h1>User</h1>

<table>
	<tr>
		<td>Name:</td>
		<td><?= $userRow['name'] ?></td>
	</tr>
	<tr>
		<td>e-mail:</td>
		<td><?= $userRow['email'] ?></td>
	</tr>
	<tr>
		<td>Username:</td>
		<td><?= $userRow['username'] ?></td>
	</tr>
	<tr>
		<td>Role:</td>
		<td><?= $userRow['role'] ?></td>
	</tr>
</table>

<?PHP

mysql_close();

include 'modules/footer.php';
?>