<?php
session_start();
echo '<link rel="stylesheet" href="projectcss.css" type="text/css">';
function makeTable(){
	$con = mysql_connect("cis.gvsu.edu","gill","gill3467"); // Need to decide which DB to use
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db("gill", $con); // Decide what DB to use (gill, etc)
	$cmd = 'CREATE TABLE IF NOT EXISTS events (name VARCHAR(50), host VARCHAR(50), rating DOUBLE, dateof DATETIME, description TEXT, PRIMARY KEY (name, host, dateof));';

	if(mysql_query($cmd))
		echo "";
	else
		die ("DID NOT CREATE TABLE!" . mysql_error());
	addEvent();
	mysql_close($con);
}

function addEvent(){
	$user = $_SESSION["username"];

	$rand = rand();

	if(empty($user)){
		echo '<p class="login">Whoops! Looks like you are not signed in. Want to:';
		echo '<a href="accountCreate.htm?v'.$rand.'"> Sign Up</a> or ';
		echo '<a href="signIn.htm?v='.$rand.'"> Sign In</a>?</p>';
		return;
	}
	$name = $_POST["event_name"];
	$host = $_POST["host"];

	$date = $_POST["datetime"];
	$text = $_POST["desc"];

	$test = explode(":", $date);
	if(count($test) == 2){
		$date = $date.":00";
	}


	if($name == "" || $host == "" || $date == ""){
		echo '<p class="err">Whoops! Looks like you forgot something. Want to:';
		echo '<a href="event_form.html?v='.$rand.'">Try Again</a>?</p>';
		return;
	}


	$name = mysql_real_escape_string($name);
	$host = mysql_real_escape_string($host);
	$date = mysql_real_escape_string($date);
	$text = mysql_real_escape_string($text);

	$date = str_replace("T", " ", $date);

	$cmd = "INSERT INTO events (name, host, dateof, description) ";
	$cmd = $cmd."VALUES ('".$name."','".$host."','".$date."','".$text."');";

	if(mysql_query($cmd))
		echo "";
	else
		die ("Error inserting" . mysql_error());

	$name = str_replace("\"", "&quot;", $name);

	// Setup form with hidden fields if user wants to review event that was created.
	echo "<h6> Want to Review this event? Fill out the info below and click submit! </h6>";
	echo '<form action="review.php" method="post" id="reviewEForm">';
	echo '<input type="hidden" name="event_name" value="'.$name.'">';
	echo '<input type="hidden" name="host" value="'.$host.'">';
	echo '<input type="hidden" name="datetime" value="'.$date.'">';
	echo '<input type="hidden" name="source" value="event">';
	echo 'Your Rating (1-5): <input type="number" min="1" max="5" name="rating"><br>';
	echo 'Your Review: <textarea name="desc" form="reviewForm"></textarea><br>';
	echo '<input type="submit" value="Submit">';
	echo '</form>';

	echo '<p class="no">No Thanks. Take me back to <a href="home.htm?v='.$rand.'">home page</a></p>';
}

?>

<html>
<head>
</head>
<body>

<?php
	makeTable();
?>


</body>
</html>
