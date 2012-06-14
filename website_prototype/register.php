<?PHP

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//include 'membersonly.php';

// retrieve our data from POST
$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
$role = $_POST['role'];

if (strlen($pass1) < 6 || $pass1 != $pass2) {
	header('Location: register_form.php');
}
if (strlen($username) <= 0 || strlen($username) > 50) {
	header('Location: register_form.php');
}
if (strlen($name) <= 0 || strlen($name) > 50) {
	header('Location: register_form.php');
}
if (strlen($email) <= 0 || strlen($email) > 50) {
	header('Location: register_form.php');
}

// Hashing
$hash = hash('sha256', $pass1);

// create a 3 character sequence
function createSalt() {
	$string = md5(uniqid(rand(), true));
	return substr($string, 0, 3);
}
$salt = createSalt();
$hash = hash('sha256', $salt . $hash);

include 'modules/connect_db.php';

$query = "INSERT INTO users (name, email, username, password, salt, role) VALUES ('".$name."', '".$email."', '".$username."', '".$hash."', '".$salt."', '".$role."');";

if (mysql_query($query, $conn)) {
	//echo "You were successfully registered.";
}
else {
	echo mysql_errno($conn). ": " . mysql_error($conn);
}

mysql_close();

header("Location: login_form.php");

?>