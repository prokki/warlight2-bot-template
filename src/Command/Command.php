<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

/**
 * OK setup_map super_regions [-i -i ...]    The superregions are given, with their bonus armies reward, all separated by spaces. Odd numbers are superregion ids, even numbers are rewards.
 * OK setup_map regions [-i -i ...]    The regions are given, with their parent superregion, all separated by spaces. Odd numbers are the region ids, even numbers are the superregion ids.
 * OK setup_map neighbors [-i [-i,...] ...]    The connectivity of the regions are given, first is the region id. Then the neighboring regions' ids, separated by commas. Connectivity is only given in one way: 'region id' < 'neighbour id'.
 * OK setup_map wastelands [-i ...]    The regions ids of the regions that are wastelands are given. These are neutral regions with more than 2 armies on them.
 * OK setup_map opponent_starting_regions [-i ...]    All the regions your opponent has picked to start on, called after distribution of starting regions.
 * OK settings timebank -i    The maximum (and initial) amount of time in the timebank is given in ms.
 * OK settings time_per_move -i    The amount of time that is added to your timebank each time a move is requested in ms.
 * OK settings max_rounds -i    The maximum amount of rounds in this game. When this number is reached it's a draw.
 * OK settings your_bot -b    The name of your bot is given.
 * OK settings opponent_bot -b    The name of your opponent bot is given.
 * OK settings starting_armies -i    The amount of armies your bot can place on the map at the start of this round.
 * OK settings starting_regions [-i ...]    The complete list of starting regions your bot can pick from is given, before pick_starting_regions is called.
 * OK settings starting_pick_amount -i    The amount of regions your bot can pick from the above list.
 * OK update_map [-i -b -i ...]    Visible map for the bot is given like this: region id; player owning region; number of armies.
 * OK opponent_moves [‑m ...]    all the visible moves the opponent has done are given in consecutive order. -m can be any move and has the same format as in the table below
 * OK pick_starting_region -t [-i ...]    Starting regions to be chosen from are given, one region id is to be returned by your bot
 * OK go place_armies -t    Request for the bot to return his place armies moves.
 * OK go attack/transfer -t    Request for the bot to return his attack and/or transfer moves
 *
 * Output from bot    Description
 *  -i    A single id of a region, returned when the pick_starting_region request has been made.
 *  [-b place_armies -i -i, ...]    Place armies moves, returned after request. With bot name, region id and number of armies.
 *  [-b attack/transfer -i -i -i, ...]    Attack/transfer moves, returned after request. With bot name, source region, target region, number of armies.
 *  No moves    return this if you want the bot to do nothing at all
 */
abstract class Command
{

	/**
	 * @param Player   $player
	 * @param SetupMap $map
	 *
	 * @return
	 */
	abstract public function apply(Player $player, SetupMap $map);

	/**
	 * Returns `true` if the command is computable (has method `compute()`, see interface {@see Computable), else `false`.
	 *
	 * @return boolean
	 */
	public function isComputable()
	{
		return in_array(Computable::class, class_implements($this));
	}

}