<?php 

include_once("../php/database.php");

$npc_id = $_REQUEST['npc_id'];

$result = $db->query(

"SELECT *, npc_types.name AS `npc_types.name`, races.name AS `races.name`, class_skill.name AS `class_skill.name` 
FROM npc_types, races, class_skill
WHERE npc_types.id = '$npc_id'
AND npc_types.race = races.id
AND npc_types.class = class_skill.class;");

if($result){
	
	$row = $result->fetch_assoc();
	?>	
	
		<div class="row">
			<!-- General -->
			<div class="col-lg-3">
				<dl class="dl-horizontal">
					<dt>Name</dt>
					<dd><?= str_replace("#", "", str_replace("_", " ", $row['npc_types.name'])); ?></dd>
					<dt>Race</dt>
					<dd><?= $row['races.name']; ?></dd>
					<dt>Class</dt>
					<dd><?= $row['class_skill.name']; ?></dd>
					<dt>Level</dt>
					<dd><?= $row['level']; ?></dd>
					<dt>Max Level</dt>
					<dd><?= $row['maxlevel']; ?></dd>
					<dt>Body Type</dt>
					<dd><?= $row['bodytype']; ?></dd>
					<dt>Vendor</dt>
					<dd><?= $row['merchant_id'] == NULL ? "no" : "yes" ?></dd>
					<dt>Alt Currency</dt>
					<dd><?= $row['alt_currency_id'] == NULL ? "no" : "yes" ?></dd>
					<dt>Adventure</dt>
					<dd><?= $row['adventure_template_id'] == NULL ? "no" : "yes" ?></dd>
					<dt>Trap</dt>
					<dd><?= $row['trap_template'] == NULL ? "no" : "yes" ?></dd>
					<dt>Tint</dt>
					<dd><?= $row['armortint_id'] == NULL ? "no" : "yes" ?></dd>
					<dt>Pet</dt>
					<dd>no</dd>
					<dt>EmoteID</dt>
					<dd><?= $row['emote_id'] == NULL ? "no" : "yes" ?></dd>
				</dl>
			</div>
			<!-- Vitals -->
			<div class="col-lg-9">
				<h3>Vitals</h3>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>AC:</dt>
						<dd><?= $row['AC']; ?></dd>
						<dt>Run:</dt>
						<dd><?= $row['runspeed']; ?></dd>
						<dt>See Invis:</dt>
						<dd><?= $row['see_invis'] > 0 ? "yes" : "no" ?></dd>
						<dt>See Imp Hide:</dt>
						<dd><?= $row['see_improved_hide'] > 0 ? "yes" : "no" ?></dd>
					</dl>
				</div>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>HP:</dt>
						<dd><?= $row['hp']; ?></dd>
						<dt>Acy:</dt>
						<dd><?= $row['Accuracy']; ?></dd>
						<dt>See ITU:</dt>
						<dd><?= $row['see_invis_undead'] > 0 ? "yes" : "no" ?></dd>
						<dt>Scalerate:</dt>
						<dd><?= $row['scalerate']; ?></dd>
					</dl>
				</div>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>Mana:</dt>
						<dd><?= $row['mana']; ?></dd>
						<dt>ATK:</dt>
						<dd><?= $row['ATK']; ?></dd>
						<dt>See Hide:</dt>
						<dd><?= $row['see_hide'] > 0 ? "yes" : "no" ?></dd>
					</dl>
				</div>
			</div>
			<!-- Stats -->
			<div class="col-lg-9">
				<h3>Stats</h3>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>STR:</dt>
						<dd><?= $row['STR']; ?></dd>
						<dt>AGI:</dt>
						<dd><?= $row['AGI']; ?></dd>
						<dt>CHA:</dt>
						<dd><?= $row['CHA'] > 0 ? "yes" : "no" ?></dd>
					</dl>
				</div>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>STA:</dt>
						<dd><?= $row['STA']; ?></dd>
						<dt>INT:</dt>
						<dd><?= $row['_INT']; ?></dd>
					</dl>
				</div>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>DEX:</dt>
						<dd><?= $row['DEX']; ?></dd>
						<dt>WIS:</dt>
						<dd><?= $row['WIS']; ?></dd>
					</dl>
				</div>
			</div>
			<!-- Resists -->
			<div class="col-lg-9 col-lg-offset-3">
				<h3>Resists</h3>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>MR:</dt>
						<dd><?= $row['MR'] . ' (' . (0.4 * $row['MR']) . '%)'; ?></dd>
						<dt>PR:</dt>
						<dd><?= $row['PR'] . ' (' . (0.4 * $row['PR']) . '%)'; ?></dd>
					</dl>
				</div>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>CR:</dt>
						<dd><?= $row['CR'] . ' (' . (0.4 * $row['CR']) . '%)'; ?></dd>
						<dt>DR:</dt>
						<dd><?= $row['DR'] . ' (' . (0.4 * $row['DR']) . '%)'; ?></dd>
					</dl>
				</div>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>FR:</dt>
						<dd><?= $row['FR'] . ' (' . (0.4 * $row['FR']) . '%)'; ?></dd>
						<dt>Corrup:</dt>
						<dd><?= $row['Corrup'] . ' (' . (0.4 * $row['Corrup']) . '%)'; ?></dd>
					</dl>
				</div>
			</div>
			<!-- Combat -->
			<div class="col-lg-9 col-lg-offset-3">
				<h3>Combat</h3>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>MinDmg:</dt>
						<dd><?= $row['mindmg']; ?></dd>
						<dt>Loottable ID:</dt>
						<dd><?= $row['loottable_id']; ?></dd>
						<dt>Aggro:</dt>
						<dd><?= $row['aggroradius']; ?></dd>
						<dt>Assist:</dt>
						<dd><?= $row['assistradius']; ?></dd>
						<dt>Slow Mit:</dt>
						<dd><?= $row['slow_mitigation']; ?></dd>
					</dl>
				</div>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>MaxDmg:</dt>
						<dd><?= $row['maxdmg']; ?></dd>
						<dt>HP Regen:</dt>
						<dd><?= $row['hp_regen_rate']; ?></dd>
						<dt>Atk Speed:</dt>
						<dd><?= $row['attack_speed'] . '%'; ?></dd>
						<dt>Spell Scale:</dt>
						<dd><?= $row['spellscale'] . '%'; ?></dd>
						<dt>Heal Scale:</dt>
						<dd><?= $row['healscale'] . '%'; ?></dd>
					</dl>
				</div>
				<div class="col-lg-3">
					<dl class="dl-horizontal">
						<dt>Attack Count:</dt>
						<dd><?= $row['attack_count']; ?></dd>
						<dt>MP Regen:</dt>
						<dd><?= $row['mana_regen_rate']; ?></dd>
						<dt>Special Attacks:</dt>
						<dd><?= $row['npcspecialattks'] > 0 ? "yes" : "None" ?></dd>
						<dt>NPC Spells ID:</dt>
						<dd><?= $row['npc_spells_id']; ?></dd>
						<dt>NPC Aggro:</dt>
						<dd><?= $row['npc_aggro']; ?></dd>
					</dl>
				</div>
			</div>
		</div>
		
	<?php
	
	// Free result set
	$result->close();
	$db->next_result();
}
else
	echo $db->error;

?>