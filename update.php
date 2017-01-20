<?php

	function update(){
		$con = mysql_connect("cis.gvsu.edu","gill","gill3467");
		if(!$con)
			die("Could not connect: " . mysql_error());

		mysql_select_db("gill", $con);

		$cmd = "SELECT * from events;";

		$result = mysql_query($cmd);

		$name;
		$host;
		$dateof;


		while($row = mysql_fetch_assoc($result)){
			$name = $row['name'];
			$host = $row['host'];
			$dateof = $row['dateof'];

			$name = mysql_real_escape_string($name);
			$host = mysql_real_escape_string($host);
			$dateof = mysql_real_escape_string($dateof);

			echo $name;
			echo '<br>';
			echo $host;
			echo '<br>';

			$cmd2 = 'SELECT * FROM reviews WHERE (event_name = "'.$name.'") AND (host = "'.$host.'") AND (dateof = "'.$dateof.'");';

			$inner = mysql_query($cmd2);

			$sum = 0;
			$count = 0;
			while($inRow = mysql_fetch_assoc($inner)){
				$sum = $sum + $inRow['rating'];
				$count++;
			}


			$average = $sum / $count;
			if($count == 0)
				$average = 0;
			$cmd2 = "UPDATE events SET rating=".$average." WHERE name='".$row['name']."' AND host='".$row['host']."' AND dateof='".$row['dateof']."';";

			mysql_query($cmd2);
		}
	}
	update();

?>
