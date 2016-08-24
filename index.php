<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PEQ Editor</title>
	
    <!-- PEQ Editor CSS -->
    <link href="css/peqeditor.css" rel="stylesheet">
    <link href="extensions/Magelo/stylesheets/character.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/examples/dashboard/dashboard.css" rel="stylesheet">
  <style type="text/css"></style><style id="holderjs-style" type="text/css"></style>
</head>
	
<body style="">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/magelo">Taken Practice Server Magelo</a>
        </div>
      </div>
    </div>
	
	<?
	
	require_once("php/database.php");
	require_once("php/functions.php");
	require_once("php/character.class.php");	

	$character = NULL;
	
	if(isset($_REQUEST['name']))
	{
		$name = $_REQUEST['name'];
		$character = new Character($name);
	
		if($character != NULL) {
		} else {
			echo "Character: $name Not Found";
		}
		
?>
	
	<div class="container-fluid">
		<div class="IventoryOuter">
			
			<div class="IventoryTitle">
				<div class="IventoryTitleLeft"></div>
				<div class="IventoryTitleMid"><b><?= $character->GetFullName() ?></b></div>
				<div class="IventoryTitleRight"></div>
			</div>
				
   			<div class="InventoryInner">
				<div class="InventoryStats2">
   	   			<table class="StatTable">
   	      			  	<tbody>
						<!--<tr><td>Guild:</td></tr>-->
          				  	<!--<tr><td><?= $character->guild ?></td></tr>-->
   	    				</tbody>
				</table>
   	  		</div>				
				
   			<div class="InventoryStats">
   				<table class="StatTable">
   					<tbody>
						<tr><td colspan="2"><?= $character->level . ' ' . $character->class ?><br><?= $character->race ?><br><i><?= $character->deity ?></i></td></tr>
   						<tr><td colspan="2" style="height: 6px"></td></tr>
   						<tr>
   							<td>HP<br>MANA<br>AC<br>ATK</td>
   							<td width="100%"><?= $character->hp ?><br><?= $character->mana ?><br><?= $character->ac ?><br><?= $character->atk ?></td>
   						</tr>
   						<tr><td class="Divider" colspan="2"></td></tr>
   						<tr>
   							<td>STR<br>STA<br>AGI<br>DEX</td>
   							<td width="100%"><?= $character->display('str') ?><br><?= $character->display('sta') ?><br><?= $character->display('agi') ?><br><?= $character->display('dex') ?></td>
   						</tr>
   						<tr><td class="Divider" colspan="2"></td></tr>
   						<tr>
   							<td>WIS<br>INT<br>CHA</td>
							<td width="100%"><?= $character->display('wis') ?><br><?= $character->display('int') ?><br><?= $character->display('cha') ?></td>
   						</tr>
   						<tr><td class="Divider" colspan="2"></td></tr>
   						<tr>
   							<td>POISON<br>MAGIC<br>DISEASE<br>FIRE<br>COLD</td>
   							<td><?= $character->display('pr') ?><br><?= $character->display('mr') ?><br><?= $character->display('dr') ?><br><?= $character->display('fr') ?><br><?= $character->display('cr') ?></td>
   						</tr>
   						<tr><td class="Divider" colspan="2"></td></tr>
   						<tr>
   							<td>WEIGHT</td>
   							<td><?= number_format($character->weight, 0) ?>/<?= $character->str ?></td>
   						</tr>
   					</tbody>
				</table>
   			</div>

   			<div class="InventoryMonogram"><img src="./images/<?= $character->class ?>.gif"></div>

   			<div class="Coin" style="top: 106px;left: 317px;"><table class="StatTable"><tbody><tr><td align="left"><img src="extensions/Magelo/images/pp.gif"></td><td align="center" width="100%"><?= $character->pp ?></td></tr></tbody></table></div>
   			<div class="Coin" style="top: 134px;left: 317px;"><table class="StatTable"><tbody><tr><td align="left"><img src="extensions/Magelo/images/gp.gif"></td><td align="center" width="100%"><?= $character->gp ?></td></tr></tbody></table></div>
   			<div class="Coin" style="top: 162px;left: 317px;"><table class="StatTable"><tbody><tr><td align="left"><img src="extensions/Magelo/images/sp.gif"></td><td align="center" width="100%"><?= $character->sp ?></td></tr></tbody></table></div>
   			<div class="Coin" style="top: 190px;left: 317px;"><table class="StatTable"><tbody><tr><td align="left"><img src="extensions/Magelo/images/cp.gif"></td><td align="center" width="100%"><?= $character->cp ?></td></tr></tbody></table></div>

 			<div class="Slot slotloc1 slotimage1"></div>
			<? if(isset($character->inventory[1])) renderItem($character->inventory[1]); ?>

			<div class="Slot slotloc2 slotimage2"></div>
			<? if(isset($character->inventory[2])) renderItem($character->inventory[2]); ?>

			<div class="Slot slotloc3 slotimage3"></div>
			<? if(isset($character->inventory[3])) renderItem($character->inventory[3]); ?>

			<div class="Slot slotloc4 slotimage4"></div>
			<? if(isset($character->inventory[4])) renderItem($character->inventory[4]); ?>

			<div class="Slot slotloc17 slotimage17"></div>
			<? if(isset($character->inventory[17])) renderItem($character->inventory[17]); ?>

			<div class="Slot slotloc5 slotimage5"></div>
			<? if(isset($character->inventory[5])) renderItem($character->inventory[5]); ?>

			<div class="Slot slotloc7 slotimage7"></div>
			<? if(isset($character->inventory[7])) renderItem($character->inventory[7]); ?>

			<div class="Slot slotloc8 slotimage8"></div>
			<? if(isset($character->inventory[8])) renderItem($character->inventory[8]); ?>

			<div class="Slot slotloc20 slotimage20"></div>
			<? if(isset($character->inventory[20])) renderItem($character->inventory[20]); ?>

			<div class="Slot slotloc6 slotimage6"></div>
			<? if(isset($character->inventory[6])) renderItem($character->inventory[6]); ?>

		   	<div class="Slot slotloc9 slotimage9"></div>
			<? if(isset($character->inventory[9])) renderItem($character->inventory[9]); ?>

		   	<div class="Slot slotloc10 slotimage10"></div>
			<? if(isset($character->inventory[10])) renderItem($character->inventory[10]); ?>

		 	<div class="Slot slotloc18 slotimage18"></div>
			<? if(isset($character->inventory[18])) renderItem($character->inventory[18]); ?>

		   	<div class="Slot slotloc12 slotimage12"></div>
			<? if(isset($character->inventory[12])) renderItem($character->inventory[12]); ?>

		   	<div class="Slot slotloc19 slotimage19"></div>
			<? if(isset($character->inventory[19])) renderItem($character->inventory[19]); ?>

		   	<div class="Slot slotloc15 slotimage15"></div>
			<? if(isset($character->inventory[15])) renderItem($character->inventory[15]); ?>

		   	<div class="Slot slotloc16 slotimage16"></div>
			<? if(isset($character->inventory[16])) renderItem($character->inventory[16]); ?>

		   	<div class="Slot slotloc13 slotimage13"></div>
			<? if(isset($character->inventory[13])) renderItem($character->inventory[13]); ?>

		   	<div class="Slot slotloc14 slotimage14"></div>
			<? if(isset($character->inventory[14])) renderItem($character->inventory[14]); ?>
			
		   	<div class="Slot slotloc11 slotimage11"></div>
			<? if(isset($character->inventory[11])) renderItem($character->inventory[11]); ?>

		   	<div class="Slot slotloc21 slotimage21"></div>
			<? if(isset($character->inventory[21])) renderItem($character->inventory[21]); ?>
			
		   	<div class="Slot slotloc22 slotimage"></div>
			<? if(isset($character->inventory[22])) renderItem($character->inventory[22]); ?>

		   	<div class="Slot slotloc23 slotimage"></div>
			<? if(isset($character->inventory[23])) renderItem($character->inventory[23]); ?>

		   	<div class="Slot slotloc24 slotimage"></div>
			<? if(isset($character->inventory[24])) renderItem($character->inventory[24]); ?>

		   	<div class="Slot slotloc25 slotimage"></div>
			<? if(isset($character->inventory[25])) renderItem($character->inventory[25]); ?>

		   	<div class="Slot slotloc26 slotimage"></div>
			<? if(isset($character->inventory[26])) renderItem($character->inventory[26]); ?>
		   
		   	<div class="Slot slotloc27 slotimage"></div>
			<? if(isset($character->inventory[27])) renderItem($character->inventory[27]); ?>
		   
		   	<div class="Slot slotloc28 slotimage"></div>
			<? if(isset($character->inventory[28])) renderItem($character->inventory[28]); ?>
		   
		   	<div class="Slot slotloc29 slotimage"></div>	
			<? if(isset($character->inventory[29])) renderItem($character->inventory[29]); ?>	
		</div>
	</div>
	
	<?
	
	}
	
	$query = "	
	SELECT character_data.name AS name, character_data.level AS level, class_skill.name AS class
	FROM character_data 
	JOIN class_skill ON character_data.class = class_skill.class ORDER BY name ASC;";
	
	$result = $db->query($query);

	if($result)
	{
		
	?>
	
	<div style="padding-top:50px;">
		<table id="characters" class="table table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Level</th>
					<th>Class</th>
				</tr>
			</thead>
			<tbody>
			
		<?
		
			while($char = $result->fetch_assoc())
			{
				?>
			
				<tr onClick="window.location.href = '?name=<?= $char['name']?>';">
					<td><?= $char['name']?></td>
					<td><?= $char['level']?></td>
					<td><?= $char['class']?></td>
				</tr>
			
				<?
			}
		}
		
		?>
	
	
			</tbody>
		</table>
	</div>
  
  <script src="js/jquery.min.js"></script>
  <script src="js/tooltips.js"></script>
  
  <div id="itemHoverContainer"><div id="itemHoverContent"></div></div>

</html>
</body>
