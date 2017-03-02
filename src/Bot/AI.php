<?php

namespace Prokki\Warlight2BotTemplate\Bot;

interface AI
{
	/**
	 * Returns the id of the region to pick.
	 *
	 * @param integer[] $region_ids
	 *
	 * @return PickMove|null
	 */
	public function getPickMove($region_ids);

	/**
	 * @return PlaceMove[]
	 */
	public function getPlaceMoves();

	/**
	 * @return TransferMove[]
	 */
	public function getAttackTransferMoves();
}