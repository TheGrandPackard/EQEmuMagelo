<?php 

include_once("../php/database.php");

$zone = $_REQUEST['zone'];

$result = $db->query(

"SELECT npc_types.id, npc_types.name, zone.short_name

FROM npc_types, spawnentry, spawngroup, spawn2, zone

WHERE npc_types.id = spawnentry.npcID 
AND spawnentry.spawngroupID = spawngroup.id 
AND spawngroup.id = spawn2.spawngroupID 
AND spawn2.zone = zone.short_name
AND zone.short_name = '$zone'

GROUP BY npc_types.id

ORDER BY npc_types.name ASC");

if($result)
{	
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
	echo $db->error;



?>