<?PHP
if (!isset($_GET['subject_id']) || is_null($_GET['subject_id']) || !is_numeric($_GET['subject_id'])) {
	header("Location: subjects.php");
}

$subject_id = $_GET['subject_id'];

include 'modules/header.php';		
include 'modules/connect_db.php';

$query = "SELECT * FROM subjects WHERE id = '$subject_id';";
$result = mysql_query($query);
	
if (mysql_num_rows($result) < 1) {
	header('Location: subjects.php');
}
?>
<p>
	<a href="subjects.php">Subjects</a> -> 
	<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
	New Category
</p>

<h1>New Category</h1>

<form name="category" action="create_category.php" method="post">
	
	<table>
		<tr>
			<td>Name/Title:</td>
			<td><input type="text" name="name" maxlength="50" size="50" /></td>
		</tr>
		<tr>
			<td>Code:</td>
			<td><input type="text" name="code" maxlength="50" /></td>
		</tr>
		<tr>
			<td><input type="hidden" name="subject_id" value="<?= $subject_id ?>" /></td>
			<td><input type="submit" value="Register" /></td>
		</tr>
	</table>
</form>

<?PHP
mysql_close();

include 'modules/footer.php';
?>
