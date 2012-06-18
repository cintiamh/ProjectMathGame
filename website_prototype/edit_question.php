<?PHP
/*
EDIT.PHP
Allows user to edit specific entry in database
*/

include 'modules/user_validation.php';
include 'modules/connect_db.php';
include 'modules/retrieve_question_ids.php';

// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($question_id, $question, $grade, $level, $active, $explanation, $category_id, $subject_id, $error)
{
include 'modules/header.php';
?>

<p>
	<a href="subjects.php">Subjects</a> ->
	<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
	<a href="view_category.php?subject_id=<?= $subject_id ?>&category_id=<?= $category_id ?>">View Category</a> ->
	Edit Question
</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>
<h1>Edit Question</h1>
	
	<form name="question" action="" method="post">
		<input type="hidden" name="id" value="<?= $question_id ?>" />
		<input type="hidden" name="category_id" value="<?= $category_id ?>" />
		<input type="hidden" name="subject_id" value="<?= $subject_id ?>" />
		<p>
			Question:<br />
			<textarea name="question" cols="100" rows="10"><?= $question ?></textarea>
		</p>
		<p>
			Grade:<br />
			<input type="number" name="grade" value="<?= $grade ?>" />
		</p>
		<p>
			Level:<br />
			<input type="number" name="level" value="<?= $level ?>" />
		</p>
		<p>
			<input type="checkbox" name="active" value="active" <?php if ($active) echo "checked" ?>/> Active
		</p>
		<p>
			Explanation:<br />
			<textarea name="explanation" cols="100" rows="10"><?= $explanation ?></textarea>
		</p>
		<p>
			<input type="submit" value="Submit" />
		</p>
	</form>

<?PHP
include 'modules/footer.php';
}

// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['id']))
{
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
	{
		// get form data, making sure it is valid
		$id = $_POST['id'];
		$subject_id = $_POST['subject_id'];
		$category_id = $_POST['category_id'];
		$question = mysql_real_escape_string(htmlspecialchars($_POST['question']));
		$grade = $_POST['grade'];
		$level = $_POST['level'];
		$active = $_POST['active'];
		$explanation = mysql_real_escape_string(htmlspecialchars($_POST['explanation']));
		
		// check that firstname/lastname fields are both filled in
		if ($question == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';
			
			//error, display form
			//renderForm($id, $name, $code, $subject_id, $error);
			renderForm($id, $question, $grade, $level, $active, $explanation, $category_id, $subject_id, $error);
		}
		else
		{
			// save the data to the database
			mysql_query("UPDATE questions SET question='$question', grade=$grade, level=$level, active=$active, explanation='$explanation', category_id='$category_id' WHERE id='$id'")
			or die(mysql_error());
			
			// once saved, redirect back to the view page
			header("Location: view_question.php?id=".$id);
		}
	}
	else
	{
		// if the 'id' isn't valid, display an error
		echo 'Error!';
	}
}
else
// if the form hasn't been submitted, get the data from the db and display the form
{
	$question_id = $questionRow["id"];
	$question = $questionRow["question"];
	$grade = $questionRow["grade"];
	$level = $questionRow["level"];
	$active = $questionRow["active"];
	$explanation = $questionRow["explanation"];
	renderForm($question_id, $question, $grade, $level, $active, $explanation, $category_id, $subject_id, $error);
}
?>