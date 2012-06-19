<?PHP

include 'modules/user_validation.php';

if (!isRoleAdmin()) {
	header("Location: index.php");
}

if (!isset($_GET['subject_id']) || is_null($_GET['subject_id']) || !is_numeric($_GET['subject_id'])) {
	header("Location: subjects.php");
}

$subject_id = $_GET['subject_id'];

if (!isset($_GET['category_id']) || is_null($_GET['category_id']) || !is_numeric($_GET['category_id'])) {
	header("Location: view_subject.php?subject_id=".$subject_id);
}

$category_id = $_GET['category_id'];
		
include 'modules/connect_db.php';

// Check if subject exists
$subjectQuery = "SELECT * FROM subjects WHERE id = '$subject_id';";
$subjectResult = mysql_query($subjectQuery);
	
if (mysql_num_rows($subjectResult) < 1) {
	header('Location: subjects.php');
	//die("User doesn't exist.");
} 

// Check if category exists
$categoryQuery = "SELECT * FROM categories WHERE id='$category_id';";
$categoryResult = mysql_query($categoryQuery);
	
if (mysql_num_rows($categoryResult) < 1) {
	header("Location: view_subject.php?subject_id=".$subject_id);
}
	
$userData = mysql_fetch_array($categoryResult, MYSQL_ASSOC);

include 'modules/header.php';
?>

<p>
	<a href="subjects.php">Subjects</a> ->
	<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
	View Category
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

<h2>Questions</h2>

<?PHP
$questionQuery = "SELECT * FROM questions WHERE category_id = '$category_id';";
$questionResult = mysql_query($questionQuery);

if (mysql_num_rows($questionResult) < 1) {
	echo "There are no questions for this category.";
}
else {
	$i = 0;
	print "<table class='listing'>";
	
	while(($row = mysql_fetch_array($questionResult)) !== false) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>";
		$questionStr = $row['question'];
		if (strlen($questionStr) > 150) 
		{
    		$questionStr = wordwrap($questionStr, 150);
    		$questionStr = substr($questionStr, 0, strpos($questionStr, "\n"));
		}
		print $questionStr;
		print "</td>";
		print "<td>".$row['grade']."</td>";
		print "<td>".$row['level']."</td>";
		print "<td><a href='view_question.php?id=".$row[0]."'>View</a></td>";
		print "<td><a href='edit_question.php?id=".$row[0]."'>Edit</a></td>";
		print "<td><a href='delete_question.php?id=".$row[0]."'>Delete</a></td>";
		print "</tr>\n";
	}
	mysql_free_result($questionResult);
	print "</table>";
}

mysql_close();

?>
<p>
	<a href="new_question.php?id=<?= $category_id ?>">New</a>
</p>



<?PHP
include 'modules/footer.php';
?>
