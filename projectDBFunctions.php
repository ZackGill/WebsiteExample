<?php 
session_start(); 

function connectToDB () {
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['email'] = $_POST['email'];
	$con = mysql_connect("cis.gvsu.edu","gill","gill3467"); 
	if (!$con){
		die('Could not connect: '.mysql_error()); 
	}
	mysql_select_db ("gill", $con)
		  or die ("Unable to select database");
	
	$cmd = 'CREATE TABLE IF NOT EXISTS users (username VARCHAR(50), email VARCHAR(50), password VARCHAR(50), PRIMARY KEY (username));';

	if(mysql_query($cmd))
		echo "";
	else
		die("error" . mysql_error());

	insertValues();

	mysql_close($con);
}

function insertValues () {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['pass1'];


	$username = mysql_real_escape_string($username);
	$email = mysql_real_escape_string($email);
	$password = mysql_real_escape_string($password);

	$check = mysql_query('SELECT * FROM users WHERE (username = "'.$username.'")');
	if(!$check)
		die("Error" . mysql_error());
	if(mysql_num_rows($check) == 0){
		$result = mysql_query("INSERT INTO users (username, email, password)
        		VALUES ('".$username."','".$email."','".$password."');");
		if($result)
			echo '<p class="welcome">Welcome to Rusty Anchors ' . $_POST['username'] . '! Want to go back to the <a href="home.htm">home page?</a></p>';
		else
			die("Error" . mysql_error());
	}
	else{
		echo '<p class="error">That Username is Taken, Sorry<p> <a href="accountCreate.htm" class="account">Back to form</a>';
	}
}

?>
<html>
<head>
<link rel="stylesheet" href="projectcss.css" type="text/css">
	<title>Account Created</title>
</head>
<body>
<?php
	connectToDB();
?>
</body>
</html>
