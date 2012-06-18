<?PHP

session_start();

function validateUser($user_id, $username) {
	session_regenerate_id();
	$_SESSION['valid'] = 1;
	$_SESSION['userid'] = $user_id;
	$_SESSION['username'] = $username;
}

function isLoggedIn() {
	if (isset($_SESSION['valid']) && $_SESSION['valid']) {
		return true;
	}
	return false;
}

function logout() {
	$_SESSION = array();
	session_destroy();
}
?>