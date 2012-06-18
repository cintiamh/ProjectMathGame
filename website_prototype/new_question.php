<?php
/*
NEW.PHP
Allows user to create a new entry in the database
*/

include 'modules/user_validation.php';
include 'modules/connect_db.php';
include 'modules/retrieve_category_subject_id.php';

// creates the new record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($question, $grade, $level, $active, $explanation, $category_id, $subject_id, $error)
{
	include 'modules/header.php';
	
	?>
	<p>
		<a href="subjects.php">Subjects</a> -> 
		<a href="view_subject.php?subject_id=<?= $subject_id ?>">View Subject</a> ->
		<a href="view_category.php?subject_id=<?= $subject_id ?>&category_id=<?= $category_id ?>">View Category</a> ->
		New Question
	</p>
	
	<?php // if there are any errors, display them
	if ($error != '') {
		echo '<div style="padding:4px; border:1px solid red; color:red;">' . $error . '</div>';
	}
	?>
	
	<h1>New Question</h1>
	
	<form name="question" action="" method="post">
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

// check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['question'])) {
	
	// get form data, making sure it is valid
	$question = mysql_real_escape_string(htmlspecialchars($_POST['question']));
	$explanation = mysql_real_escape_string(htmlspecialchars($_POST['explanation']));
	$grade = $_POST['grade'];
	$level = $_POST['level'];
	if ($_POST['active'] == "active") {
		$active = true;
	}
	else {
		$active = false;
	}
	$category_id = $_POST['category_id'];
	$subject_id = $_POST['subject_id'];

	// check to make sure both fields are entered
	if ($question == '') {
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';
		// if either field is blank, display the form again
		renderForm($question, $grade, $level, $active, $explanation, $category_id, $subject_id, $error);
	} else {
		// save the data to the database
		//$insert_query = "INSERT questions SET question='$question' grade=$grade level=$level active=$active explanation='$explanation' category_id='$category_id'";
		$insert_query = "INSERT INTO questions (question, grade, level, active, explanation, category_id) VALUES ('$question', $grade, $level, '$active', '$explanation', $category_id)"; 
		mysql_query($insert_query) or die(mysql_error());

		// once saved, redirect back to the view page
		header("Location: view_category.php?subject_id=$subject_id&category_id=" . $category_id);
	}
} else
// if the form hasn't been submitted, display the form
{
	renderForm('', '', '', '', '', $category_id, $subject_id, '');
}
?> 
