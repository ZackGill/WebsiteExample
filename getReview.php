<?php


	function getReview(){
		$name = $_GET["name"];
		$host = $_GET['host'];
		$date = $_GET['date'];


		$con = mysql_connect("cis.gvsu.edu", "gill", "gill3467");
		mysql_select_db('gill', $con);

		$name = mysql_real_escape_string($name);
		$host = mysql_real_escape_string($host);
		$date = mysql_real_escape_string($date);

		$cmd = "SELECT * FROM reviews WHERE (host = '".$host."') AND (event_name = '".$name."') AND (dateof='".$date."') ORDER BY dateof DESC;";

		$result = mysql_query($cmd);
		$rows = array();
		while($r = mysql_fetch_assoc($result)){
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	getReview();


?>
