<?php

namespace Prokki\Warlight2BotTemplate\Command;

interface SendableCommand
{
	/**
	 * @param \Prokki\Warlight2BotTemplate\GamePlay\AIable   $ai
	 * @param \Prokki\Warlight2BotTemplate\Game\Player $player
	 *
	 * @return String
	 */
	public function compute($ai, $player);
}