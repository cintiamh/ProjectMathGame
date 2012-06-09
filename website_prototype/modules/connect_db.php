<?PHP
// Database configuration
$dbhost = 'localhost';
$dbname = 'math_quiz';
$dbuser = 'root';
$dbpass = '';

$conn = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);
?>