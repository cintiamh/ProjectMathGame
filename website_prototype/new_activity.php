<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

include 'modules/user_validation.php';

if (!isRoleAdmin()) {
	header("Location: index.php");
}

include 'modules/connect_db.php';
include 'modules/retrieve_user_ids.php';

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($id, $subject_id, $subject_name, $subject_arr, $category_id, $category_name, $category_arr, $question_id, $question_arr, $error)
{
	include 'modules/header.php';
?>

<p>
	<a href="users.php">Users</a> -> 
	<a href="view_user.php?id=<?= $id ?>">View User</a> ->
	New Activity
</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>

<h1>New Activity</h1>
<form name="activity" action="" method="post">
	<input type="hidden" name="user_id" value="<?= $id ?>" />
	
	<?php
	if ($subject_arr != "") {
		echo $subject_arr;
	}
	else if ($category_arr != "") {
		echo '<input type="hidden" name="subject_id" value="'.$subject_id.'" />';
		echo '<input type="hidden" name="subject_name" value="'.$subject_name.'" />';
		echo "<p>Subject: ".$subject_name."</p>";
		echo "<p>Category: ";
		echo $category_arr;
		echo "</p>";
	}
	else if ($question_arr != "") {
		echo '<input type="hidden" name="subject_id" value="'.$subject_id.'" />';
		echo '<input type="hidden" name="subject_name" value="'.$subject_name.'" />';
		echo "<p>Subject: ".$subject_name."</p>";
		echo '<input type="hidden" name="category_id" value="'.$category_id.'" />';
		echo '<input type="hidden" name="category_name" value="'.$category_name.'" />';
		echo "<p>Category: ".$category_name."</p>";
		echo "<p>Question: ";
		echo $question_arr;
		echo "</p>";
	}
	?>

	<input type="submit" value="Submit" />
</form>
<?php
	include 'modules/footer.php';
}
// check if the form has been submitted. If it has, start to process the form and save it to the database
if (!isset($_POST["subject_id"])) {
	$user_id = $id;
	$result = mysql_query("SELECT * FROM subjects");
	$subjectSelect = "<p>Subject: <select id='subjectSelect' name='subject_id'>";
	while ($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$name = $row["name"];
		 
		$subjectSelect .= "<option value='$id'>";
		$subjectSelect .= $name;
		$subjectSelect .= "</option>";
	}
	$subjectSelect.= "</select></p>";
	renderForm($user_id, "", "", $subjectSelect, "", "", "", "", "", $error);
	
}
else if (!isset($_POST["category_id"])) {
	$user_id = $_POST["user_id"];
	$subjectId = $_POST["subject_id"];
	$subjectResult = mysql_query("SELECT * FROM subjects WHERE id=$subjectId") or die(mysql_error());
	$subjectRow = mysql_fetch_array($subjectResult);
	$result = mysql_query("SELECT * FROM categories WHERE subject_id=$subjectId");
	$categorySelect = "<select name='category_id'>";
	while ($row = mysql_fetch_array($result)) {
		$id = $row["id"];
		$name = $row["name"];
		$categorySelect .= "<option value='$id'>";
		$categorySelect .= $name;
		$categorySelect .= "</option>";
	}
	$categorySelect .= "</select>";
	renderForm($user_id, $subjectId, $name, "", "", "", $categorySelect, "", "", $error);
}
else if (!isset($_POST["question_id"])) {
	$user_id = $_POST["user_id"];
	$subjectId = $_POST["subject_id"];
	$subjectName = $_POST["subject_name"];
	$categoryId = $_POST["category_id"];
	if ($categoryId != "") {
		$categoryResult = mysql_query("SELECT * FROM categories WHERE id=$categoryId") or die(mysql_error());
		$categoryRow = mysql_fetch_array($categoryResult);
		$result = mysql_query("SELECT * FROM questions WHERE category_id=$categoryId");
		$questionSelect = "<select name='question_id'>";
		while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			$question = $row["question"];
			$questionSelect .= "<option value='$id'>";
			$questionSelect .= $question;
			$questionSelect .= "</option>";
		}
		$questionSelect .= "</select>";
		renderForm($user_id, $subjectId, $subjectName, "", $categoryId, $categoryRow["name"], "", "", $questionSelect, $error);
	}
}
else if (isset($_POST['question_id']))
{
	// get form data, making sure it is valid
	$userId = $_POST["user_id"];
	$subjectId = $_POST["subject_id"];
	$subjectName = $_POST["subject_name"];
	$categoryId = $_POST["category_id"];
	$categoryName = $_POST["category_name"];
	$questionId = $_POST['question_id'];
	
	// check to make sure both fields are entered
	if ($questionId == '')
	{
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';
		
		// if either field is blank, display the form again
		renderForm($userId, $subjectId, $subjectName, "", $categoryId, $categoryName, "", "", "", $error);
	}
	else
	{
		// save the data to the database
		mysql_query("INSERT activities SET start_time=NOW(), question_id='$questionId', user_id='$userId'")
		or die(mysql_error());
		
		//header("Location: schools.php");
		header("Location: view_user.php?id=$userId");
	}
}
else
// if the form hasn't been submitted, display the form
{
	renderForm($id, "", "", "", "", "", "", "", "", "");
}
?>

