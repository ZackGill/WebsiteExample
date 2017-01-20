<?php session_start(); 

function connectToDB () {
	$con = mysql_connect("cis.gvsu.edu","gill","gill3467"); 
	if (!$con){
		die('Could not connect: '.mysql_error()); 
	}
	mysql_select_db ("gill", $con)
		  or die ("Unable to select database");

	$cmd = 'CREATE TABLE IF NOT EXISTS users (username VARCHAR(50), email VARCHAR(50), password VARCHAR(50), PRIMARY KEY (username));';

	if (mysql_query($cmd))
		echo "";
	else
		die("error" . mysql_error());

	logIn($con);

	mysql_close($con);
}

function logIn ($con) {
	
	$user = $_POST['username'];
	$pass = $_POST['pass'];

	$user = mysql_real_escape_string($user);
	$pass = mysql_real_escape_string($pass);


	$cmd = 'SELECT * FROM users WHERE (username ="'.$user.'")';
	$result = mysql_query($cmd);
	if(!$result){
		die("Error".mysql_error());
	}
	if(mysql_num_rows($result) == 0){
		echo '<p class="wrong_user">Incorrect username <a class="signIn" href="signIn.htm">try again?</a></p>';
	}
	$r = mysql_fetch_assoc($result);
	if($pass != mysql_real_escape_string($r['password'])){
		echo '<p class="wrong_pass">Invalid Password <a class="signIn" href="signIn.htm">try again?</a></p>';
	}
	else{
		$_SESSION['username'] = $user;
		echo '<p class="welcome">Welcome back ' . $_POST['username'] . '!</p>';
		echo '<a class="home" href="home.htm">Back to home page</a>';
	}
}




?>
<html>
<head>
<link rel="stylesheet" href="projectcss.css" type="text/css">
<title>Sign-In</title>
</head>
<body>
<?php
connectToDB();
?>
</body>
</html>
