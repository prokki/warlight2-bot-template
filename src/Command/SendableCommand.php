<?php

namespace Prokki\Warlight2BotTemplate\Command;

interface SendableCommand
{
	/**
	 * @param \Prokki\Warlight2BotTemplate\Game\Player $player
	 *
	 * @return String
	 */
	public function compute($player);
}