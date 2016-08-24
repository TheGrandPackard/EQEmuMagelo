<?php

define("HUMAN", "1");
define("BARBARIAN", "2");
define("ERUDITE", "3");
define("WOOD_ELF", "4");
define("HIGH_ELF", "5");
define("DARK_ELF", "6");
define("HALF_ELF", "7");
define("DWARF", "8");
define("TROLL", "9");
define("OGRE", "10");
define("HALFLING", "11");
define("GNOME", "12");
define("IKSAR", "128");
define("VAH_SHIR", "130");

define("WARRIOR", "1");
define("CLERIC", "2");
define("PALADIN", "3");
define("RANGER", "4");
define("SHADOWKNIGHT", "5");
define("DRUID", "6");
define("MONK", "7");
define("BARD", "8");
define("ROGUE", "9");
define("SHAMAN", "10");
define("NECROMANCER", "11");
define("WIZARD", "12");
define("MAGICIAN", "13");
define("ENCHANTER", "14");
define("BEASTLORD", "15");

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
	
	$start_str = 0,
        $start_sta = 0,
        $start_agi = 0,
        $start_dex = 0,
        $start_wis = 0,
        $start_int = 0,
        $start_cha = 0,

	$str = 0,
	$sta = 0,
	$agi = 0,
	$dex = 0,
	$wis = 0,
	$int = 0,
	$cha = 0,

	$start_pr = 0,
        $start_mr = 0,
        $start_dr = 0,
        $start_fr = 0,
        $start_cr = 0,

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

		$query = "	SELECT 	character.id AS id,
					character.last_name,
					character.suffix,
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
				FROM `character_data` AS `character`
				LEFT JOIN guild_members ON character.id = guild_members.char_id
				LEFT JOIN guilds ON guilds.id = guild_members.guild_id
				LEFT JOIN `character_currency` AS currency ON character.id = currency.id
				WHERE character.name LIKE '$name'";
       		 
                $result = $db->query($query) or die($db->error);;
                
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

			$this->start_str = $row['str'];
                        $this->start_sta = $row['sta'];
                        $this->start_agi = $row['agi'];
                        $this->start_dex = $row['dex'];
                        $this->start_wis = $row['wis'];
                        $this->start_int = $row['int'];
                        $this->start_cha = $row['cha'];
	
			$this->setResists();

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

						$this->str += $item['astr'];
						$this->sta += $item['asta'];
						$this->agi += $item['aagi'];
						$this->dex += $item['adex'];
						$this->wis += $item['awis'];
						$this->int += $item['aint'];
						$this->cha += $item['acha'];
						$this->weight += $item['weight'] / 10;


						$this->pr += $item['pr'];
					        $this->mr += $item['mr'];
					        $this->dr += $item['dr'];
					        $this->fr += $item['fr'];
					        $this->cr += $item['cr'];
					}
					else if($item['slotid'] < 30) {
						$this->weight += $item['weight'] / 10;	
					}
                                }
                        }

		} else {
			return NULL;
		}

   	}  

	function GetFullName() {

		$output = $this->name . ($this->suffix != "" ? " " . $this->suffix : "") . ($this->title != "" ? ", " . $this->title : "") . ($this->guild != "" ? " " . $this->guild : "") . " ";
		return $output;
	}

	function display($stat) {

		switch($stat)
		{
			case 'str':
			case 'sta':
                        case 'agi':
                        case 'dex':
                        case 'wis':
                        case 'int':
                        case 'cha':
			case 'pr':
			case 'mr':
			case 'dr':
			case 'fr':
			case 'cr':
				if($this->$stat > $this->{"start_$stat"})
					return "<span style='color:#00FF00'>" . ($this->$stat < 256 ? $this->$stat : 255) . "</span>";
				if($this->$stat < $this->{"start_" .$stat})
					return "<span style='color:#FF0000'>" . ($this->$stat < 256 ? $this->$stat : 255) . "</span>";
				return "<span>" . ($this->$stat < 256 ? $this->$stat : 255) . "</span>";
			default:
				return $this->$stat;
		}
	}	 

	function setResists() {
		
		switch($this->raceID) {

			case HUMAN:
				$this->mr += 25;
				$this->fr += 25;
				$this->dr += 15;
				$this->pr += 15;
				$this->cr += 25;	
				break;
			case BARBARIAN:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 35;
                                break;
			case ERUDITE:
                                $this->mr += 30;
                                $this->fr += 25;
                                $this->dr += 10;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case WOOD_ELF:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case HIGH_ELF:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case DARK_ELF:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case HALF_ELF:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case DWARF:
                                $this->mr += 30;
                                $this->fr += 25;
                                $this->dr += 20;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case TROLL:
                                $this->mr += 25;
                                $this->fr += 5;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case OGRE:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case HALFLING:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 20;
                                $this->pr += 20;
                                $this->cr += 25;
                                break;
			case GNOME:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			case IKSAR:
                                $this->mr += 25;
                                $this->fr += 30;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 15;
                                break;
			case VAH_SHIR:
                                $this->mr += 25;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;
			default:
				$this->mr += 20;
                                $this->fr += 25;
                                $this->dr += 15;
                                $this->pr += 15;
                                $this->cr += 25;
                                break;

		}

		switch($this->classID) {

			case WARRIOR:
				$this->mr += $this->level/2;
       				break;
			case RANGER:
				$this->fr += 4 + ($this->level > 49 ? $this->level - 49 : 0);
				$this->cr += 4 + ($this->level > 49 ? $this->level - 49 : 0);
				break;
			case MONK:
				$this->fr += 8 + ($this->level > 49 ? $this->level - 49 : 0);
				$this->dr += ($this->level > 50 ? $this->level - 50 : 0);
				$this->pr += ($this->level > 50 ? $this->level - 50 : 0);
				break;
			case PALADIN:
				$this->dr += 8 + ($this->level > 49 ? $this->level - 49 : 0);			
				break;
			case SHADOWKNIGHT:
				$this->dr += 4 + ($this->level > 49 ? $this->level - 49 : 0);			
				$this->pr += 4 + ($this->level > 49 ? $this->level - 49 : 0);
				break;
			case BEASTLORD:
				$this->dr += 4 + ($this->level > 49 ? $this->level - 49 : 0);
				$this->cr += 4 + ($this->level > 49 ? $this->level - 49 : 0);
				break;
			case ROGUE:
				$this->pr += 8 + ($this->level > 49 ? $this->level - 49 : 0);
				break;
		}

		$start_pr = $this->pr;
	        $start_mr = $this->mr;
	        $start_dr = $this->dr;
	        $start_fr = $this->fr;
	        $start_cr = $this->cr;
	 }
}

?>
