<?PHP

include 'modules/header.php';

//include 'membersonly.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Connect to database

include 'modules/connect_db.php';

$username = mysql_real_escape_string($username);
$query = "SELECT * FROM users WHERE username = '$username';";
$result = mysql_query($query);

if (mysql_num_rows($result) < 1) {
	//header('Location: login_form.php');
	die("User doesn't exist.");
}

$userData = mysql_fetch_array($result, MYSQL_ASSOC);

// Hashing
$hash = hash('sha256', $password);
$salt = $userData['salt'];
$hash = hash('sha256', $salt . $hash);

if ($hash != $userData['password']) {
	//header('Location: login_form.php');
	echo $salt. ", pass: ". $password . "\n";
	die("Incorrect password. db: ". $userData['password'] . ", local: ". $hash);
}
else {
	validateUser($userData['id'], $userData['username']);
	//echo $userData['id'];
	//print_r($userData);
}

if (!isLoggedIn()) {
	//header('Location: login.php');
	die('You are not logged in.');
}
else {
	header('Location: index.php');
	die('Logged in successfully.');
}

mysql_close();

?>