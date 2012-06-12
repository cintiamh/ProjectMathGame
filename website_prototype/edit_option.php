<?PHP
/*
EDIT.PHP
Allows user to edit specific entry in database
*/

include 'modules/connect_db.php';
include 'modules/retrieve_option_ids.php';

// creates the edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($id, $answer, $correct, $question_id, $category_id, $subject_id, $error)
{
include 'modules/header.php';
?>

	<p>
		<a href="subjects.php">Subjects</a> -> 
		<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
		<a href="view_category.php?subject_id=<?= $subject_id ?>&category_id=<?= $category_id ?>">View Category</a> ->
		<a href="view_question.php?id=<?= $question_id ?>">View Question</a> ->
		Edit Option
	</p>

<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
?>
<h1>Edit Option</h1>
	
	<form name="question" action="" method="post">
		<input type="hidden" name="id" value="<?= $id ?>" />
		<input type="hidden" name="question_id" value="<?= $question_id ?>" />
		<input type="hidden" name="category_id" value="<?= $category_id ?>" />
		<input type="hidden" name="subject_id" value="<?= $subject_id ?>" />
		<p>
			<b>Answer:</b><br />
			<textarea name="answer" cols="100" rows="10"><?= $answer ?></textarea>
		</p>
		<p>
			<input type="checkbox" name="correct" value="correct" <?php if ($correct) echo "checked" ?>/> Active
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
		$question_id = $_POST['question_id'];
		$subject_id = $_POST['subject_id'];
		$category_id = $_POST['category_id'];
		$answer = mysql_real_escape_string(htmlspecialchars($_POST['answer']));
		$correct = $_POST['correct'];
		
		// check that firstname/lastname fields are both filled in
		if ($answer == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';
			
			//error, display form
			//renderForm($id, $name, $code, $subject_id, $error);
			renderForm($id, $answer, $correct, $question_id, $category_id, $subject_id, $error);
		}
		else
		{
			// save the data to the database
			mysql_query("UPDATE options SET answer='$answer', correct='$correct', question_id='$question_id' WHERE id='$id'")
			or die(mysql_error());
			
			// once saved, redirect back to the view page
			header("Location: view_question.php?id=".$question_id);
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
	$id = $optionRow["id"];
	$question_id = $optionRow["question_id"];
	$answer = $optionRow["answer"];
	$correct = $optionRow["correct"];
	renderForm($id, $answer, $correct, $question_id, $category_id, $subject_id, $error);
}
?>