<?php


	function getEvent(){
		$name = $_GET["name"];
		$host = $_GET['host'];
		$date = $_GET['date'];
		$con = mysql_connect("cis.gvsu.edu", "gill", "gill3467");
		mysql_select_db('gill', $con);

		$result = mysql_query('SELECT * FROM events');
		$rows = array();
		while($r = mysql_fetch_assoc($result)){
			$rows[] = $r;
		}
		echo json_encode($rows);
		echo '<br>';
	}

	getEvent();


?>
