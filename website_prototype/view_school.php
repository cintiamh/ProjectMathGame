<?php

include 'modules/connect_db.php';
include 'modules/retrieve_school_ids.php';

include 'modules/header.php';
?>

<p>
	<a href="schools.php">Schools</a> ->
	View School
</p>

<h1>School</h1>

<table>
	<tr>
		<td>Name</td>
		<td><?= $schoolRow['name'] ?></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><?= $schoolRow['address'] ?></td>
	</tr>
	<tr>
		<td>City</td>
		<td><?= $schoolRow['city'] ?></td>
	</tr>
	<tr>
		<td>State</td>
		<td><?= $schoolRow['state'] ?></td>
	</tr>
</table>

<h2>Groups</h2>

<?PHP
$groupsQuery = "SELECT * FROM groups WHERE school_id = '$id';";
$groupsResult = mysql_query($groupsQuery);

if (mysql_num_rows($groupsResult) < 1) {
	echo "There are no groups for this school.";
}
else {
	$i = 0;
	print "<table class='listing'>";
	
	while(($row = mysql_fetch_array($groupsResult)) !== false) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>".$row["grade"]."</td>";
		print "<td>".$row["code"]."</td>";
		print "<td><a href='edit_group.php?id=".$row["id"]."'>Edit</a></td>";
		print "<td><a href='delete_group.php?id=".$row["id"]."'>Delete</a></td>";
		print "</tr>\n";
	}
	mysql_free_result($groupsResult);
	print "</table>";	
}

mysql_close();

?>
<p>
	<a href="new_group.php?id=<?= $id ?>">New Group</a>
</p>

<?php
include 'modules/footer.php';
?>