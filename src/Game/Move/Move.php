<?php

namespace Prokki\Warlight2BotTemplate\Game\Move;

use Prokki\Warlight2BotTemplate\Game\Player;

interface Move
{
	/**
	 * Returns the partial response string for this move.
	 *
	 * @param Player $player the player performing the move
	 *
	 * @return string
	 */
	public function _toResponseString(Player $player);

}