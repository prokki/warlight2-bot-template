<?php

namespace Prokki\Warlight2BotTemplate\Game\Move;

interface Move
{
	/**
	 * Returns the partial response string for this move.
	 *
	 * @param string $player_name the name of the player performing the move
	 *
	 * @return string
	 */
	public function _toResponseString($player_name);

}