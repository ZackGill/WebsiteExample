<?php

function get(){
	$con = mysql_connect("cis.gvsu.edu", "gill", "gill3467");
	mysql_select_db('gill', $con);

	$result = mysql_query("SELECT * FROM events ORDER BY dateof DESC;");

	$rows = array();
	while($r = mysql_fetch_assoc($result)){
		$rows[] = $r;
	}
	echo json_encode($rows);
}

get();
?>
