<?PHP

if (!isset($_GET['category_id']) || is_null($_GET['category_id']) || !is_numeric($_GET['category_id'])) {
	header("Location: subjects.php");
}

$subject_id = $_GET['subject_id'];


include 'modules/header.php';
		
include 'modules/connect_db.php';

$query = "SELECT * FROM categories WHERE id = 'category_id';";
$result = mysql_query($query);
	
if (mysql_num_rows($result) < 1) {
	header('Location: subjects.php');
}
	
$userData = mysql_fetch_array($result, MYSQL_ASSOC);

?>

<p>
	<a href="subjects.php">Subjects</a> ->
	View Subject
</p>

<h1>Category</h1>
	
<table>
	<tr>
		<td>Name/Title:</td>
		<td><?= $userData['name'] ?></td>
	</tr>
	<tr>
		<td>Code:</td>
		<td><?= $userData['code'] ?></td>
	</tr>
</table>

<h2>Categories</h2>

<?PHP
/*$query = "SELECT * FROM categories WHERE subject_id = '$subject_id';";
$result = mysql_query($query);

$userData = mysql_fetch_array($result, MYSQL_ASSOC);

if (mysql_num_rows($result) < 1) {
	echo "There are no categories for this subject.";
}
else {
	$i = 0;
	print "<table>";
	while(($row = mysql_fetch_row($result)) !== false) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>".$row[0]."</td>";
		print "<td>".$row[1]."</td>";
		print "</tr>\n";
	}
	mysql_free_result($result);
	print "</table>";	
}*/

mysql_close();

?>
<p>
	<a href="new_category.php?subject_id=<?= $subject_id ?>">New</a>
</p>



<?PHP
include 'modules/footer.php';
?>
