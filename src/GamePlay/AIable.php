<?php

namespace Prokki\Warlight2BotTemplate\GamePlay;

use Prokki\Warlight2BotTemplate\Game\Player;

interface AIable
{
	/**
	 * Returns the id of the region to pick.
	 *
	 * @param Player    $player
	 * @param integer[] $region_ids
	 *
	 * @return integer
	 */
	public function pickStartingRegion($player, $region_ids);

	/**
	 * @param Player $player
	 *
	 * @return PlaceMove[]
	 */
	public function getPlaceMoves($player);

	/**
	 * @param Player $player
	 *
	 * @return TransferMove[]
	 */
	public function getAttackTransferMoves($player);
}