<?PHP

session_start();

function validateUser($user_id, $username, $role, $school_id) {
	session_regenerate_id();
	$_SESSION['valid'] = 1;
	$_SESSION['userid'] = $user_id;
	$_SESSION['username'] = $username;
	$_SESSION['role'] = $role;
	$_SESSION['schoolid'] = $school_id;
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

function isRoleAdmin() {
	if (isset($_SESSION['role']) && $_SESSION['role'] == "Administrator") {
		return true;
	}
	return false;
}

/*function isRoleSchoolAdmin() {
	if (isset($_SESSION['role']) && $_SESSION['role'] == "SchoolAdmin") {
		return true;
	}
	return false;
}*/

function isRoleTeacher() {
	if (isset($_SESSION['role']) && $_SESSION['role'] == "Teacher") {
		return true;
	}
	return false;
}

function isRoleStudent() {
	if (isset($_SESSION['role']) && $_SESSION['role'] == "Student") {
		return true;
	}
	return false;
}

?>