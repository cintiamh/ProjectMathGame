<?PHP
include 'modules/header.php';
include 'modules/connect_db.php';

$query = "SELECT * FROM subjects;";
$result = mysql_query($query);

$userData = mysql_fetch_array($result, MYSQL_ASSOC);
?>
<h1>Subjects</h1>
<?PHP
if (mysql_num_rows($result) < 1) {
	echo "There are no subjects.";
}
else {
	$i = 0;
	print "<table class='listing'>";
	while(($row = mysql_fetch_row($result)) !== false) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>".$row[1]."</td>";
		print "<td>".$row[2]."</td>";
		print "<td><a href='view_subject.php?subject_id=".$row[0]."'>View</a></td>";
		print "<td><a href='edit_subject.php?subject_id=".$row[0]."'>Edit</a></td>";
		print "<td><a href='delete_subject.php?id=".$row[0]."'>Delete</a></td>";
		print "</tr>\n";
	}
	mysql_free_result($result);
	print "</table>";	
}

mysql_close();
?>
<p>
	<a href="new_subject.php">New Subject</a>
</p>


<?PHP
include 'modules/footer.php';
?>
