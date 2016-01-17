<?

// TODO: AC, ATK, Bag Item Weight
// TODO: EXPENDABLE (Vibrating Gauntlets of Infuse)
// TODO: Item Deity

// Functionality that did NOT exist with Magelo
// TODO: Stack Count for stackable items
// TODO: Open Bags!

	include_once("php/database.php");

	function renderItem($item)
	{	
		echo '
		<a href="http://wiki.project1999.com/' . str_replace(" ", "_", $item['Name']) . '"><div class="Slot slotloc' . $item['slotid'] . ' magelohb" style="background-image: url(images/Item_' . $item['itemicon'] . '.png);"><span class="hb" style="position: fixed; top: 263px; left: 569px; z-index: 999;"><div class="itemtopbg"><div class="itemtitle">' . $item['Name'] . '</div></div>
		<div class="itembg"><div class="itemdata">
		<div class="itemicon"><div class="floatright"><img alt="Item ' . $item['itemicon'] . '.png" src="images/Item_' . $item['itemicon'] . '.png" width="40" height="40"></div></div>';
		
		global $statFlag, $resistFlag;
		
		$statFlag = false;
		$resistFlag = false;

		$itemStat = function($stat)
		{
			global $statFlag;
			
			if ($stat > 0)
			{
				$statFlag = true;
				return "+$stat";
			}
			else if ($stat < 0)
			{
				$statFlag = true;
				return "-$stat";
			}
			else
				return NULL;	
		};

		$itemResist = function($resist)
		{
			global $resistFlag;
			
			if ($resist > 0)
			{
				$resistFlag = true;
				return "+$resist";
			}
			else if ($resist < 0)
			{
				$resistFlag = true;
				return "-$resist";
			}
			else
				return NULL;	
		};		
		// If Bag
		if($item['bagslots']  > 0)
		{
			echo 'WT: ' . number_format((float) ($item['weight'] / 10), 1) . '  Weight Reduction: ' . $item['bagwr'] . '%<br>
			Capacity: ' . $item['bagslots'] . ' Size Capacity: ' . itemSize($item['bagsize']) ;
		}
		// Others
		else
		{
			echo '<p>'.
			($item['magic'] > 0 ? "MAGIC ITEM " : "").
			($item['loregroup'] != 0 ? "LORE ITEM " : "").
			($item['pendingloreflag'] > 0 ? "PENDING LORE " : "").
			($item['artifactflag'] > 0 ? "ARTIFACT " : "").
			($item['nodrop'] == 0 ? "NO DROP " : "").
			($item['questitemflag'] > 0 ? "QUEST ITEM " : "").
			($item['norent'] == 0 ? "TEMPORARY " : "").
			'<br>'. 
			slotsForBitmap($item['slots']) .
			
			// Spell Info
			($item['type'] == 20 ? 'Level Needed: ' . scrollClasses($item) . '<br/>' : '').
			($item['type'] == 20 ? 'Skill: ' . spellSkill($item['scrollskill']) . '<br/>' : '').
			($item['type'] == 20 ? 'Mana Cost: ' . $item['scrollmana'] . '<br/>' : '').
			
			// Charges
			($item['type'] == 21 ? "EXPENDABLE " : "").
			($item['maxcharges'] > 0 ? 'Charges: ' . $item['charges'] . '<br/>' : '').
			
			// Bard Instrument Type
			($item['type'] >= 23 && $item['type'] <= 26 ? itemTypes($item['type']) . ': ' . $item['bardvalue'] . '<br>' : '').
			
			// Weapon Skill and Delay
			($item['delay'] > 0 ? 'Skill: ' . itemTypes($item['type']) . ' ' : '').
			($item['delay'] > 0 ? 'Atk Delay: ' . $item['delay'] . ' ' : '').
			($item['delay'] > 0 ? '<br>' : '').
			
			// Weapon Damage and AC
			($item['damage'] > 0 ? 'DMG: ' . $item['damage'] . ' ' : '').
			($item['ac'] > 0 ? 'AC: ' . $item['ac'] : '').
			($item['damage'] > 0 || $item['ac'] > 0 ? '<br>' : '').
			
			// Stats
			($itemStat($item['astr']) != NULL ? 'STR: ' . $itemStat($item['astr']) . ' ' : '').
			($itemStat($item['adex']) != NULL ? 'DEX: ' . $itemStat($item['adex']) . ' ' : '').
			($itemStat($item['asta']) != NULL ? 'STA: ' . $itemStat($item['asta']) . ' ' : '').
			($itemStat($item['aagi']) != NULL ? 'AGI: ' . $itemStat($item['aagi']) . ' ' : '').
			($itemStat($item['acha']) != NULL ? 'CHA: ' . $itemStat($item['acha']) . ' ' : '').
			($itemStat($item['awis']) != NULL ? 'WIS: ' . $itemStat($item['awis']) . ' ' : '').
			($itemStat($item['aint']) != NULL ? 'INT: ' . $itemStat($item['aint']) . ' ' : '').
			($itemStat($item['hp']) != NULL ? 'HP: ' . $itemStat($item['hp']) . ' ' : '').
			($itemStat($item['itemmana']) != NULL ? 'MANA: ' . $itemStat($item['itemmana']) . ' ' : '').
			($statFlag ? '<br>' : '')
			
			// Resists
			 . ($itemResist($item['fr']) != NULL ? 'SV FIRE: ' . $itemResist($item['fr']) : '').'
			'. ($itemResist($item['dr']) != NULL ? 'SV DISEASE: ' . $itemResist($item['dr']) : '').'
			'. ($itemResist($item['cr']) != NULL ? 'SV COLD: ' . $itemResist($item['cr']) : '').'
			'. ($itemResist($item['mr']) != NULL ? 'SV MAGIC: ' . $itemResist($item['mr']) : '').'
			'. ($itemResist($item['pr']) != NULL ? 'SV POISON: ' . $itemResist($item['pr']) : '').
			($resistFlag ? '<br>' : '') .
						
			// Click Effect
			($item['clickeffect'] > 0 ? 'Effect: ' . $item['clickiename'] . ' (' . clickieType($item['clicktype']) . ', Casting Time: ' . ($item['casttime'] > 0 ? number_format((float) ($item['casttime'] / 1000), 1) : 'Instant') . ') at Level ' . $item['clicklevel2'] . '<br>' : ''). 
			
			// Proc Effect
			($item['proceffect'] > 0 ? 'Effect: ' . $item['procname'] . ' (Combat, Casting Time: Instant) 
			at Level ' . $item['proclevel'] . '<br>' : ''). 
			
			// Worn Effect
			($item['worneffect'] > 0 ? 'Effect: ' . $item['wornname'] . ' (Worn, Casting Time: Instant) <br>' : ''). 
			
			// Worn Haste
			($item['haste'] > 0 ? 'Haste + ' . $item['haste'] . '%<br>' : ''). 
			
			'WT: ' . number_format((float) ($item['weight'] / 10), 1) . '  Size: ' . itemSize($item['size']) . '<br>'.
			($item['type'] != 20 ? 'Class: ' . itemClasses($item['classes']) . '<br>' : '').
			'Race: ' . itemRaces($item['races']) . '<br>
			</p>';
		 }
		
		echo '
		</div></div><div class="itembotbg"></div>
		</span></div></a>';
	}
	
	function spellSkill($skill)
	{
		switch($skill)
		{
			case 4: return "Abjuration";
			case 5: return "Alteration";
			case 14: return "Conjuration";
			case 18: return "Divination";
			case 24: return "Evocation";
			default: "UNKNOWN";
		}
	}
	
	function scrollClasses($scroll)
	{
		$classes = "";
	
		if($scroll['classes1'] < 255) $classes .= "WAR(" . $scroll['classes1'] . ") ";
		if($scroll['classes2'] < 255) $classes .= "CLR(" . $scroll['classes2'] . ") ";
		if($scroll['classes3'] < 255) $classes .= "PAL(" . $scroll['classes3'] . ") ";
		if($scroll['classes4'] < 255) $classes .= "RNG(" . $scroll['classes4'] . ") ";
		if($scroll['classes5'] < 255) $classes .= "SHD(" . $scroll['classes5'] . ") ";
		if($scroll['classes6'] < 255) $classes .= "DRU(" . $scroll['classes6'] . ") ";
		if($scroll['classes7'] < 255) $classes .= "MNK(" . $scroll['classes7'] . ") ";
		if($scroll['classes8'] < 255) $classes .= "BRD(" . $scroll['classes8'] . ") ";
		if($scroll['classes9'] < 255) $classes .= "ROG(" . $scroll['classes9'] . ") ";
		if($scroll['classes10'] < 255) $classes .= "SHM(" . $scroll['classes10'] . ") ";
		if($scroll['classes11'] < 255) $classes .= "NEC(" . $scroll['classes11'] . ") ";
		if($scroll['classes12'] < 255) $classes .= "WIZ(" . $scroll['classes12'] . ") ";
		if($scroll['classes13'] < 255) $classes .= "MAG(" . $scroll['classes13'] . ") ";
		if($scroll['classes14'] < 255) $classes .= "ENC(" . $scroll['classes14'] . ") ";
		if($scroll['classes15'] < 255) $classes .= "BST(" . $scroll['classes15'] . ") ";
		
		return $classes;
	}
	
	function itemTypes($type)
	{
		switch($type)
		{
			case 0:
				return "1H Slashing";
			case 1:
				return "2H Slashing";
			case 2:
				return "Piercing";
			case 3:
				return "1H Blunt";
			case 4:
				return "2H Blunt";
			case 5:
				return "Archery";
			case 7:
			case 19:
				return "Throwing";
			case 23:
				return "Wind Instruments";
			case 24:
				return "Stringed Instruments";
			case 25:
				return "Brass Instruments";
			case 26:
				return "Percussion Instruments";
			case 45:
				return "Hand to Hand";
			default:
				return "";			
		}
	}
	
	function itemRaces($races)
	{
		if($races == 65535) return "ALL";
		
		$return = "";
		
		if($races & 1) $return .= "HUM ";
		if($races & 2) $return .= "BAR ";
		if($races & 4) $return .= "ERU ";
		if($races & 8) $return .= "ELF ";
		if($races & 16) $return .= "HIE ";
		if($races & 32) $return .= "DEF ";
		if($races & 64) $return .= "HEF ";
		if($races & 128) $return .= "DWF ";
		if($races & 256) $return .= "TRL ";
		if($races & 512) $return .= "OGR ";
		if($races & 1024) $return .= "HFL ";
		if($races & 2048) $return .= "GNM ";
		if($races & 56101) $return .= "IKS";
		// Vah Shir??
		
		return ($return == "" ? "NONE" : $return);
	}
	
	function itemClasses($classes)
	{
		if($classes == 65535) return "ALL";
		
		$return = "";
		
		if($classes & 1) $return .= "WAR ";
		if($classes & 2) $return .= "CLR ";
		if($classes & 4) $return .= "PAL ";
		if($classes & 8) $return .= "RNG ";
		if($classes & 16) $return .= "SHD ";
		if($classes & 32) $return .= "DRU ";
		if($classes & 64) $return .= "MNK ";
		if($classes & 128) $return .= "BRD ";
		if($classes & 256) $return .= "ROG ";
		if($classes & 512) $return .= "SHM ";
		if($classes & 1024) $return .= "NEC ";
		if($classes & 2048) $return .= "WIZ ";
		if($classes & 4096) $return .= "MAG ";
		if($classes & 8192) $return .= "ENC ";
		if($classes & 16384) $return .= "BST ";
		
		return ($return == "" ? "NONE" : $return);
	}
	
	function itemSize($size)
	{
		switch($size)
		{
			case 0:
				return "TINY";
			case 1:
				return "SMALL";
			case 2:
				return "MEDIUM";
			case 3:
				return "LARGE";
			case 4:
			case 5:
			case 6:
				return "GIANT";
			default:
				return "UNKNOWN";
		}
	}
	
	function slotsForBitmap($slots)
	{
		$return = "";
		
		if($slots & 1) $return .= "CHARM ";
		if($slots & 2) $return .= "EAR ";
		if($slots & 4) $return .= "HEAD ";
		if($slots & 8) $return .= "FACE ";
		if($slots & 32) $return .= "NECK ";
		if($slots & 64) $return .= "SHOULDERS ";
		if($slots & 128) $return .= "ARMS ";
		if($slots & 256) $return .= "BACK ";
		if($slots & 512) $return .= "WRIST ";
		if($slots & 2048) $return .= "RANGE ";
		if($slots & 4096) $return .= "HANDS ";
		if($slots & 8192) $return .= "PRIMARY ";
		if($slots & 16384) $return .= "SECONDARY ";
		if($slots & 32768) $return .= "FINGER ";
		if($slots & 131072) $return .= "CHEST ";
		if($slots & 262144) $return .= "LEGS ";
		if($slots & 524288) $return .= "FEET ";
		if($slots & 1048576) $return .= "WAIST ";
		if($slots & 2097152) $return .= "AMMO ";
		if($slots & 4194304) $return .= "POWER SOURCE ";
		
		return ($return == "" ? "" : 'Slot: ' . $return . '<br>');
	}
	
	function clickieType($clicktype)
	{
		switch($clicktype)
		{
			case 1:
				return 'Any Slot';
			case 3:
				return 'Any Slot';
			case 4:
				return 'Must Equip';
			case 5:
				return 'Any Slot/Can Equip';
		}
	}
	
	function classNameFromID($classID)
	{		
		switch($classID)
                {
                        case 1: return "Warrior";
                        case 2: return "Cleric";
                        case 3: return "Paladin";
                        case 4: return "Ranger";
                        case 5: return "Shadowknight";
                        case 6: return "Druid";
                        case 7: return "Monk";
                        case 8: return "Bard";
                        case 9: return "Rogue";
                        case 10: return "Shaman";
                        case 11: return "Necromancer";
                        case 12: return "Wizard";
                        case 13: return "Magician";
                        case 14: return "Enchanter";
                        case 15: return "Beastlord";
                        default: return "UNKNOWN";
                }
	}
	
	function raceNameFromID($raceID)
	{
		switch($raceID)
		{
			case 1: return "Human";
                        case 2: return "Barbarian";
                        case 3: return "Erudite";
                        case 4: return "Wood Elf";
                        case 5: return "High Elf";
                        case 6: return "Dark Elf";
                        case 7: return "Half-Elf";
                        case 8: return "Dwarf";
                        case 9: return "Troll";
                        case 10: return "Ogre";
                        case 11: return "Halfling";
                        case 12: return "Gnome";
			case 128: return "Iksar";
			case 130: return "Vah Shir";
			default: return "UNKNOWN";	
		}
	}
	
	function deityNameFromID($deityID)
	{
		switch($deityID)
		{	
			case 396: return "Agnostic";
			case 201: return /*The Plaguebringer*/ "Bertoxxulous";
			case 202: return /*The Duke of Below*/ "Brell Serilis";
			case 203: return /*The Faceless*/ "Cazic-Thule";	
			case 204: return /*The Queen of Love*/ "Erollisi Marr";				
			case 205: return /*The King of Thieves*/ "Bristlebane";		
			case 206: return /*The Prince of Hate*/ "Innoruuk";	
			case 207: return /*The Rainkeeper*/ "Karana";		
			case 208: return /*The Lightbearer*/ "Mithaniel Marr";
			case 209: return /*The Oceanlord*/ "Prexus";		
			case 210: return /*The Tranquil*/ "Quellious";		
			case 211: return /*The Warlord*/ "Rallos Zek";	
			case 212: return /*The Prime Healer*/ "Rodcet Nife";			
			case 213: return /*The Burning Prince*/ "Solusek Ro";
			case 214: return /*The Six Hammers*/ "The Tribunal";
			case 215: return /*The Mother of All*/ "Tunare";
			case 216: return /*The Wurmqueen*/ "Veeshan";	
			default: return "UNKNOWN";
		}
	}
?>
