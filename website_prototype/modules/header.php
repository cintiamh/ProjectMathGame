<?PHP
if(!isset($_SESSION)) { 
	session_start(); 
}  
include 'modules/user_validation.php';
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];	
} else {
	$username = "Guest";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MathQuizShow</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/elements.css" />
  <link href='http://fonts.googleapis.com/css?family=Butterfly+Kids' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Sniglet:800' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Rammetto+One' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Flavors' rel='stylesheet' type='text/css'>
</head>
<body>
<header>
  <div id="header_content">
    <span class="header_letter1">M</span>
    <span class="header_letter2">a</span>
    <span class="header_letter3">t</span>
    <span class="header_letter1">h</span>
    <span class="header_letter2">Q</span>
    <span class="header_letter3">u</span>
    <span class="header_letter1">i</span>
    <span class="header_letter2">z</span>
    <div id="login_link">
    	<?PHP
    	if (isLoggedIn()) {
    		echo "Welcome, ". $username. ". ";
			echo "Not you? <a href='logout.php'>Logout</a>.";
    	} else {
    		echo "<a href='register_form.php'>Register</a> or ";
			echo "<a href='login_form.php'>Sign in</a>";
    	}
    	?>      		
      	
    </div>
  </div>

</header>
<nav>
  <div id="nav_content">
  	<a href="#" class="green_button">Activities</a>
  	<a href="subjects.php" class="green_button">Subjects</a>
  	<a href="schools.php" class="green_button">Schools</a>
  	<a href="#" class="green_button">Users</a>
  </div>
</nav>
<div id="main">
  <div id="game_window">