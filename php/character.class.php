<?php

class Character {

	var $id = 0,
	$name = "",
	$last_name = "",
	$suffix = "",
	$title = "",
	$guild = "",
	$guildID = 0,	

	$level = 1,
	$class = "UNKNOWN",
	$classID = 0,
	$race = "UNKNOWN",
	$raceID = 0,
	$deity = "UNKNOWN",
	$deityID = 0,

	$hp = 0,
	$mana = 0,
	$atk = 0,
	$ac = 0,

	$str = 0,
	$sta = 0,
	$agi = 0,
	$dex = 0,
	$wis = 0,
	$int = 0,
	$cha = 0,

	$pr = 0,
	$mr = 0,       
	$dr = 0,
	$fr = 0,
	$cr = 0,

	$pp = 0,
	$gp = 0,
	$sp = 0,
	$cp = 0,

	$weight = 0,

	$inventory = array();

	function Character($name) {
		
		global $db;

		$this->name = $name;

		$query = "      SELECT  character.id AS id,
					character.last_name, 
                                        character.suffix,
                                        character.title,
                                        guilds.name AS guild_name,
                                        guilds.id AS guild_id,
                                        character.level,
                                        character.class,
                                        character.race,
                                        character.deity,
                                        character.str,
                                        character.sta,
                                        character.agi,
                                        character.dex,
                                        character.wis,
                                        character.int,
                                        character.cha,
                                        currency.platinum,
                                        currency.gold,
                                        currency.silver,
                                        currency.copper
                                FROM character_data AS `character`, character_currency AS currency, guilds, guild_members
                                WHERE character.name LIKE '$name' AND
                                character.id = currency.id AND
                                guild_members.char_id = character.id AND
                                guilds.id = guild_members.guild_id
			;";
        
                $result = $db->query($query);
                
	        if($result) {
			$row = $result->fetch_assoc();

			$this->id = $row['id'];
			$this->last_name = (isset($row['last_name']) ? $row['last_name'] : "");
			$this->suffix = (isset($row['suffix']) ? $row['suffix'] : "");
			$this->title = (isset($row['title']) ? $row['title'] : "");;
			$this->guild = (isset($row['guild_name']) ? "&lt;" . $row['guild_name'] . "&gt;" : "");
			$this->guildID = $row['guild_id'];
		
			$this->level = $row['level'];
			$this->classID = $row['class'];
			$this->class = classNameFromID($this->classID);

			$this->raceID = $row['race'];
			$this->race = raceNameFromID($this->raceID);
			$this->deityID = $row['deity'];
			$this->deity = deityNameFromID($this->deityID);

			// hp
			// mana
			// atk

			$this->str = $row['str'];
			$this->sta = $row['sta'];
                        $this->agi = $row['agi'];
                        $this->dex = $row['dex'];
                        $this->wis = $row['wis'];
                        $this->int = $row['int'];
                        $this->cha = $row['cha'];

			// pr
			// mr
			// dr
			// fr
			// cr

			$this->pp = $row['platinum'];
                        $this->gp = $row['gold'];
                        $this->sp = $row['silver'];
                        $this->cp = $row['copper'];


			$query = "
SELECT *, itemType AS type, items.mana AS itemmana, items.icon AS itemicon, proc.name AS procname, clickie.name AS clickiename, worn.name AS wornname, scroll.mana AS scrollmana, scroll.skill AS scrollskill
FROM inventory 
JOIN items ON inventory.itemid = items.id
LEFT JOIN spells_new AS proc ON items.proceffect = proc.id
LEFT JOIN spells_new AS clickie ON items.clickeffect = clickie.id
LEFT JOIN spells_new AS worn ON items.worneffect = worn.id
LEFT JOIN spells_new AS scroll ON items.scrolleffect = scroll.id
WHERE charid = " . $this->id . ";";

                        $result = $db->query($query);

                        if($result){

                                while($item = $result->fetch_assoc())
                                {
                                        $this->inventory[$item['slotid']] = $item;
	
					if($item['slotid'] < 22) {
						// Add up stats and weight here
					}
                                }
                        }

		} else {
			die("Invalid Character Name");
			return NULL;
		}

   	}  

	function GetFullName() {

		$output = $this->name . ($this->suffix != "" ? " " . $this->suffix : "") . ($this->title != "" ? ", " . $this->title : "") . ($this->guild != "" ? " " . $this->guild : "") . " ";
		return $output;
	} 
}

?>
