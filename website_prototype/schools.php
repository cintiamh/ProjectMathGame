<?PHP
include 'modules/header.php';
include 'modules/connect_db.php';

$query = "SELECT * FROM schools";
$result = mysql_query($query);
?>
<h1>Schools</h1>
<?PHP
if (mysql_num_rows($result) < 1) {
	echo "There are no schools.";
}
else {
	$i = 0;
	print "<table class='listing'>";
	while($row = mysql_fetch_array($result)) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>".$row["name"]."</td>";
		print "<td>".$row["city"]."</td>";
		print "<td>".$row["state"]."</td>";
		print "<td><a href='view_school.php?id=".$row["id"]."'>View</a></td>";
		print "<td><a href='edit_school.php?id=".$row["id"]."'>Edit</a></td>";
		print "<td><a href='delete_school.php?id=".$row["id"]."'>Delete</a></td>";
		print "</tr>\n";
	}
	echo mysql_error();
	mysql_free_result($result);
	print "</table>";	
}

mysql_close();
?>
<p>
	<a href="new_school.php">New School</a>
</p>


<?PHP
include 'modules/footer.php';
?>
