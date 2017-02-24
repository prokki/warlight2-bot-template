<?php

namespace Prokki\Warlight2BotTemplate\GamePlay;

use Prokki\Warlight2BotTemplate\Game\Environment;

interface AIable
{
	/**
	 * Returns the id of the region to pick.
	 *
	 * @param Environment $environment
	 * @param integer[]   $region_ids
	 *
	 * @return integer
	 */
	public function pickStartingRegion(Environment $environment, $region_ids);

	/**
	 * @param Environment $environment
	 *
	 * @return PlaceMove[]
	 */
	public function getPlaceMoves(Environment $environment);

	/**
	 * @param Environment $environment
	 *
	 * @return TransferMove[]
	 */
	public function getAttackTransferMoves(Environment $environment);
}