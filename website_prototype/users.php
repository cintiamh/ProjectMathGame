<?PHP

include 'modules/user_validation.php';
include 'modules/header.php';
include 'modules/connect_db.php';

$query = "SELECT * FROM users";
$result = mysql_query($query);
?>
<h1>Users</h1>
<?PHP
if (mysql_num_rows($result) < 1) {
	echo "There are no users.";
}
else {
	$i = 0;
	print "<table class='listing'>";
	while($row = mysql_fetch_array($result)) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>".$row["name"]."</td>";
		print "<td>".$row["email"]."</td>";
		print "<td>".$row["username"]."</td>";
		print "<td>".$row["role"]."</td>";
		print "<td><a href='view_user.php?id=".$row["id"]."'>View</a></td>";
		print "<td><a href='edit_user.php?id=".$row["id"]."'>Edit</a></td>";
		print "<td><a href='delete_user.php?id=".$row["id"]."'>Delete</a></td>";
		print "</tr>\n";
	}
	echo mysql_error();
	mysql_free_result($result);
	print "</table>";	
}

mysql_close();
?>
<p>
	<a href="register_form.php">New User</a>
</p>


<?PHP
include 'modules/footer.php';
?>
