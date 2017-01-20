<?php
session_start();
function makeTable(){
	$con = mysql_connect("cis.gvsu.edu","gill","gill3467");
	if(!$con)
		die("Could not connect: " . mysql_error());

	mysql_select_db("gill", $con);
	$cmd = 'CREATE TABLE IF NOT EXISTS reviews (user_name VARCHAR(50), event_name VARCHAR(50), host VARCHAR(50), rating TINYINT, dateof DATETIME, description TEXT, PRIMARY KEY (user_name, event_name, host, dateof));';

	mysql_query($cmd);

	addReview();
	mysql_close($con);
}

function addReview(){
	$rand = rand();
	$user = $_SESSION["username"];
	if(empty($user)){
		echo '<p class="login">Whoops! Looks like you are not signed in. Want to:';
		echo '<a href="accountCreate.htm?v='.$rand.'"> Sign Up</a> or ';
		echo '<a href="signIn.htm?v='.$rand.'"> Sign In</a>?</p>';
		return;
	}
	$event_name = $_POST["event_name"];
	$host = $_POST["host"];
	$date = $_POST["datetime"];
	$source = $_POST["source"];

	$test = explode(":", $date);
	if(count($test) == 2){
		$date = $date.":00";
	}

	$rating = $_POST["rating"];
	$desc = $_POST["desc"];

	if($event_name == "" || $host == "" || $date == "" || $rating == ""){
		echo '<p class="err">Whoops! Looks like you forgot something. Want to:';
		$event_name = urlencode($event_name);
		echo '<a href="review_form.htm#event_name='.$event_name.'&host='.$host.'&datetime='.$date.'">Try Again</a>?</p>';
		return;
	}

	if($source != "event"){
		$event_name = mysql_real_escape_string($event_name);
		$date = mysql_real_escape_string($date);
		$host = mysql_real_escape_string($host);
		$rating = mysql_real_escape_string($rating);
	}

	$date = str_replace("T", " ", $date);

	$desc = mysql_real_escape_string($desc);

	$test = "SELECT * from events WHERE name = '".$event_name."' AND dateof='".$date."';";
	$testR = mysql_query($test);
	if(mysql_num_rows($testR) <= 0){
		echo mysql_error();
		echo 'Invalid Event!';
		return;
	}


	$cmd = "INSERT INTO reviews (user_name, event_name, host, rating, dateof, description) ";
	$cmd = $cmd."VALUES ('".$user."','".$event_name."','".$host."',".$rating.",'".$date."','".$desc."');";
	if(mysql_query($cmd))
		echo "";
	else{
		echo '<p class="dup"> Whoops! Looks like you reviewed this event already. Want to go <a class="home" href="home.htm?v='.$rand.'"> back to the home page?</a></p>';
		return;
	}
	// Select all items with same Event key as new insert, update the event's average rating.
	$cmd = "SELECT rating from reviews WHERE event_name='".$event_name."' AND host='".$host."' AND dateof='".$date."';";

	$result = mysql_query($cmd);

	$sum = 0;
	$count = 0;

	while($row = mysql_fetch_row($result)){
		// For Each cell in row (which is just 1)
		foreach($row as $cell){
			$sum = $sum + $cell;
			$count++;
		}
	}

	$average = $sum / $count;
	// Update
	$cmd = "UPDATE events SET rating=".$average." WHERE name='".$event_name."' AND host='".$host."' AND dateof='".$date."';";

	if(mysql_query($cmd))
		echo '<p class="thanks">Thank You. Would you like to go <a class="home" href="home.htm?v='.$rand.'"> back to the home page?</p>';
	else
		die ("Error updating" . mysql_error());
}


?>

<html>
<head>
<link rel="stylesheet" href="projectcss.css" type="text/css">
</head>
<body>
<?php
	makeTable();
?>
</body>
</html>
