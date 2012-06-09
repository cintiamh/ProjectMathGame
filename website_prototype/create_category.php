<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// retrieve our data from POST
$name = $_POST['name'];
$code = $_POST['code'];
$subject_id = $_POST['subject_id'];

if (strlen($subject_id) <= 0) {
	header('Location: subjects.php');
}
if (strlen($name) <= 0 || strlen($name) > 50) {
	header('Location: new_category.php?subject_id='.$subject_id);
}
if (strlen($code) <= 0 || strlen($code) > 50) {
	header('Location: new_category.php?subject_id='.$subject_id);
}

include 'modules/connect_db.php';

$mysqldate = date( 'Y-m-d H:i:s' );
$phpdate = strtotime( $mysqldate );
$query = "INSERT INTO categories (name, code, subject_id) VALUES ('".$name."', '".$code."', ". $subject_id .");";

if (mysql_query($query, $conn)) {
	echo "Subject saved.";
	$last_id = mysql_insert_id();
}
else {
	echo mysql_errno($conn). ": " . mysql_error($conn);
}

mysql_close();

header("Location: view_category.php?category_id=" . $last_id);

?>