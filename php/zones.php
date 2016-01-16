<?php

include_once("../php/database.php");
		  
$result = $db->query("SELECT id, short_name FROM zone");

if($result){
	
	$data = array();
	
	while ($row = $result->fetch_assoc()){
		$data[] = $row;
	}
	// Free result set
	$result->close();
	$db->next_result();

	echo json_encode($data);
}
else
{
	echo $db->error;
}
?>