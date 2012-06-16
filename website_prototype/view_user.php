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

<h2>Activities</h2>

<?PHP
$activityQuery = "SELECT * FROM activities WHERE user_id = '$id';";
$activityResult = mysql_query($activityQuery);

if (mysql_num_rows($activityResult) < 1) {
	echo "There are no activities for this user.";
}
else {
	$i = 0;
	print "<table class='listing'>";
	while(($row = mysql_fetch_array($activityResult)) !== false) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>".$row["success"]."</td>";
		print "<td>".$row["start_time"]."</td>";
		print "<td>".$row["end_time"]."</td>";
		print "<td>".$row["question_id"]."</td>";
		print "<td>";
		if ($row["end_time"] == "") {
			print "<a href='finish_activity.php?id=".$row["id"]."'>Finish Activity</a></td>";	
		}
		print "<td><a href='delete_activity.php?id=".$row["id"]."'>Delete</a></td>";
		print "</tr>\n";
	}
	mysql_free_result($activityResult);
	print "</table>";	
}

mysql_close();

?>
<p>
	<a href="new_activity.php?id=<?= $id ?>">New Activity</a>
</p>

<?PHP
include 'modules/footer.php';
?>