<?PHP
include 'modules/user_validation.php';

if (!isRoleAdmin()) {
	header("Location: index.php");
}

// Connects to the database
include 'modules/connect_db.php';
// Checks the given question id and gets the category id and the subject id from it.
include 'modules/retrieve_question_ids.php';

include 'modules/header.php';
?>

<p>
	<a href="subjects.php">Subjects</a> ->
	<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
	<a href="view_category.php?subject_id=<?= $subject_id ?>&category_id=<?= $category_id ?>">View Category</a> ->
	View Question
</p>

<h1>Question</h1>

<p>
	<b>Question:</b><br />
	<?= $questionRow['question'] ?>
</p>
<p>
	<b>Grade:</b>
	<?= $questionRow['grade'] ?>
</p>
<p>
	<b>Level:</b>
	<?= $questionRow['level'] ?>
</p>
<p>
	<b>Active:</b>
	<?php
	if ($questionRow['active']) {
		echo "Yes";
	}
	else {
		echo "No";
	}
	?>
</p>
<p>
	<b>Explanation:</b><br />
	<?= $questionRow['explanation'] ?>
</p>

<h2>Options</h2>

<?PHP
$optionQuery = "SELECT * FROM options WHERE question_id = '$question_id';";
$optionResult = mysql_query($optionQuery);

if (mysql_num_rows($optionResult) < 1) {
	echo "There are no options for this question.";
}
else {
	$i = 0;
	print "<table class='listing'>";
	
	while(($row = mysql_fetch_array($optionResult)) !== false) {
		$i++;
		print "<tr class=\"d".($i & 1)."\">";
		print "<td>".$row['answer']."</td>";
		print "<td>".$row['correct']."</td>";
		print "<td><a href='edit_option.php?id=".$row[0]."'>Edit</a></td>";
		print "<td><a href='delete_option.php?id=".$row[0]."'>Delete</a></td>";
		print "</tr>\n";
	}
	mysql_free_result($optionResult);
	print "</table>";
}

mysql_close();

?>
<p>
	<a href="new_option.php?id=<?= $question_id ?>">New</a>
</p>



<?PHP
include 'modules/footer.php';
?>
