<?PHP

include 'modules/user_validation.php';

if (!isset($_GET['subject_id']) || is_null($_GET['subject_id']) || !is_numeric($_GET['subject_id'])) {
	header("Location: subjects.php");
}

$subject_id = $_GET['subject_id'];


include 'modules/header.php';
		
include 'modules/connect_db.php';

$subjectQuery = "SELECT * FROM subjects WHERE id = '$subject_id';";
$subjectResult = mysql_query($subjectQuery);
	
if (mysql_num_rows($subjectResult) < 1) {
	header('Location: subjects.php');
	//die("User doesn't exist.");
}
	
$subjectData = mysql_fetch_array($subjectResult, MYSQL_ASSOC);
//mysql_free_result($result);

?>

<p>
	<a href="subjects.php">Subjects</a> ->
	View Subject
</p>

<h1>Subject</h1>
	
<table>
	<tr>
		<td>Name/Title:</td>
		<td><?= $subjectData['name'] ?></td>
	</tr>
	<tr>
		<td>Code:</td>
		<td><?= $subjectData['code'] ?></td>
	</tr>
</table>

<h2>Categories</h2>

<?PHP
$query2 = "SELECT * FROM categories WHERE subject_id = '$subject_id';";
$result2 = mysql_query($query2);

if (mysql_num_rows($result2) < 1) {
	echo "There are no categories for this subject.";
}
else {
	$i = 0;
	print "<table class='listing'>";
	
	while(($row = mysql_fetch_row($result2)) !== false) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>".$row[1]."</td>";
		print "<td>".$row[2]."</td>";
		print "<td><a href='view_category.php?subject_id=$subject_id&category_id=".$row[0]."'>View</a></td>";
		print "<td><a href='edit_category.php?id=".$row[0]."'>Edit</a></td>";
		print "<td><a href='delete_category.php?id=".$row[0]."'>Delete</a></td>";
		print "</tr>\n";
	}
	mysql_free_result($result2);
	print "</table>";	
}

mysql_close();

?>
<p>
	<a href="new_category.php?subject_id=<?= $subject_id ?>">New</a>
</p>



<?PHP
include 'modules/footer.php';
?>
