<?php

function dropTable(){
	$con = mysql_connect("cis.gvsu.edu", "gill", "gill3467");
	if(!$con){
		die('Could not connect: '.mysql_error());
	}
	
	mysql_select_db("gill", $con);

	$cmd = "DROP TABLE events;";
	if(mysql_query($cmd))
		echo "Dropped events";
	else
		die("Erorr on dropping" . mysql_error());
	$cmd = "DROP TABLE reviews;";
	if(mysql_query($cmd))
		echo "Dropped reviews";
	$cmd = "DROP TABLE users;";
	if(mysql_query($cmd))
		echo "Dropped users";

	mysql_close($con);
}

?>

<html>
<body>

<?php
	dropTable();
?>
<p>This script drops the table;</p>
<a href="event_form.html">Back to form</a>
</body>
</html>
