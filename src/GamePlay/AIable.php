<?php

namespace Prokki\Warlight2BotTemplate\GamePlay;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

interface AIable
{
	/**
	 * Returns the id of the region to pick.
	 *
	 * @param Player    $player
	 * @param Map       $map
	 * @param integer[] $region_ids
	 *
	 * @return integer
	 */
	public function pickStartingRegion(Player $player, Map $map, $region_ids);

	/**
	 * @param Player $player
	 * @param Map    $map
	 *
	 * @return PlaceMove[]
	 */
	public function getPlaceMoves(Player $player, Map $map);

	/**
	 * @param Player $player
	 * @param Map    $map
	 *
	 * @return TransferMove[]
	 */
	public function getAttackTransferMoves(Player $player, Map $map);
}