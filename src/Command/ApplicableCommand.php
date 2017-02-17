<?php

namespace Prokki\Warlight2BotTemplate\Command;

interface ApplicableCommand
{
	
	/**
	 * @param \Prokki\Warlight2BotTemplate\Game\Player $player
	 */
	public function apply($player);
}