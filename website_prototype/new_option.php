<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

include 'modules/user_validation.php';
include 'modules/connect_db.php';
include 'modules/retrieve_question_ids.php';

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($answer, $correct, $question_id, $category_id, $subject_id, $error)
{
	include 'modules/header.php';
	
	?>
	<p>
		<a href="subjects.php">Subjects</a> -> 
		<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
		<a href="view_category.php?subject_id=<?= $subject_id ?>&category_id=<?= $category_id ?>">View Category</a> ->
		<a href="view_question.php?id=<?= $question_id ?>">View Question</a> ->
		New Option
	</p>
	
	<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
	?>
	
	<h1>New Option</h1>
	
	<form name="question" action="" method="post">
		<input type="text" name="question_id" value="<?= $question_id ?>" />
		<input type="text" name="category_id" value="<?= $category_id ?>" />
		<input type="text" name="subject_id" value="<?= $subject_id ?>" />
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

// check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['answer'])) {
	
	// get form data, making sure it is valid
	$answer = mysql_real_escape_string(htmlspecialchars($_POST['answer']));
	$correct = false;
	if ($_POST['correct'] == "correct") {
		$correct = true;
	}
	$question_id = $_POST['question_id'];
	$category_id = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];

	// check to make sure both fields are entered
	if ($answer == '') {
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';
		// if either field is blank, display the form again
		renderForm($answer, $correct, $question_id, $category_id, $subject_id, $error);
	} else {
		// save the data to the database
		//$insert_query = "INSERT questions SET question='$question' grade=$grade level=$level active=$active explanation='$explanation' category_id='$category_id'";
		$insert_query = "INSERT INTO options (answer, correct, question_id) VALUES ('$answer', '$correct', $question_id)"; 
		//echo $insert_query;
		mysql_query($insert_query) or die(mysql_error());

		// once saved, redirect back to the view page
		header("Location: view_question.php?id=" . $question_id);
	}
} else
// if the form hasn't been submitted, display the form
{
	renderForm('', true, $question_id, $category_id, $subject_id, '');
}
?> 
