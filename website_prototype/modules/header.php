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
    		echo "Welcome, ". $_SESSION['username']. ". ";
			echo "Not you? <a href='logout.php'>Logout</a>.";
    	} else {
    		echo "<a href='register.php'>Register</a> or ";
			echo "<a href='login.php'>Sign in</a>";
    	}
    	?>      		
      	
    </div>
  </div>

</header>
<nav>
  <div id="nav_content">
  	
  	<?php
  	if (isLoggedIn()) {
  		echo '<a href="view_user.php?id='. $_SESSION['userid']. '" class="green_button">Activities</a>';
  	}
  	if (isRoleAdmin() || isRoleTeacher()) {
  		echo '<a href="subjects.php" class="green_button">Subjects</a>';
  		echo '<a href="schools.php" class="green_button">Schools</a>';
  		echo '<a href="users.php" class="green_button">Users</a>';
  	} 
  	?>
  </div>
</nav>
<div id="main">
  <div id="game_window">