<?php

namespace Prokki\Warlight2BotTemplate\Bot;

use Prokki\Warlight2BotTemplate\Game\Move\AttackMove;

interface AI
{
	/**
	 * Returns the pick move of the region to pick.
	 *
	 * These moves are going to build the response to the request `pick_starting_region` - see {@see \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand}.
	 *
	 * @param integer[] $region_ids
	 *
	 * @return PickMove|null
	 */
	public function getPickMove($region_ids);

	/**
	 * Returns all place moves.
	 *
	 * These moves are going to build the response to the request `go place_armies` - see {@see \Prokki\Warlight2BotTemplate\Command\GoPlaceArmiesCommand}.
	 *
	 * @return PlaceMove[]
	 */
	public function getPlaceMoves();

	/**
	 * Returns all attack and transfer moves.
	 *
	 * These moves are going to build the response to the request `go attack/transfer` - see {@see \Prokki\Warlight2BotTemplate\Command\GoAttackTransferCommand}.
	 *
	 * @return TransferMove[]|AttackMove[]
	 */
	public function getAttackTransferMoves();
}