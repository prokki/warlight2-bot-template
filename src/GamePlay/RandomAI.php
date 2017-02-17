<?php

namespace Prokki\Warlight2BotTemplate\GamePlay;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\GamePlay\PlaceMove;

/**
 * @since  2017-02-15
 * @author Falko Matthies <falko.m@web.de>
 */
class RandomAI implements AIable
{

	/**
	 * @inheritdoc
	 */
	public function pickStartingRegion($player, $region_ids)
	{
		$index = rand(0, count($region_ids) - 1);

		$region = $player->getMap()->getRegion($region_ids[ $index ]);

		$region->getState()->setOwner(RegionState::OWNER_ME);

		return $region->getId();
	}

	/**
	 * @inheritdoc
	 */
	public function getAttackTransferMoves($player)
	{
		return array();
	}

	/**
	 * @inheritdoc
	 */
	public function getPlaceMoves($player)
	{
		$armies_to_dispense = $player->getSetting()->getStartingArmies();

		$my_region_ids = $player->getMap()->getRegions(RegionState::OWNER_ME)->getOffsets();

		$armies_to_place = array();

		$circa_placements = min(count($my_region_ids), rand(1, ceil(log($armies_to_dispense, 1.75))));

		$placement_round_no = 1;

		do
		{
			$_already_placed_armies = array_sum($armies_to_place);

			$_max_armies_to_place_this_round = $armies_to_dispense - $_already_placed_armies;

			$_armies_this_round = rand(1, $_max_armies_to_place_this_round - $circa_placements + $placement_round_no);

			array_push($armies_to_place, $_armies_this_round);

			++$placement_round_no;
		}
		while( array_sum($armies_to_place) < $armies_to_dispense );

		$moves = array();

		foreach( $armies_to_place as $_armies )
		{
			shuffle($my_region_ids);

			array_push($moves, new PlaceMove(array_pop($my_region_ids), $_armies));
		}

		return $moves;
	}
}