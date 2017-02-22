<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

interface ApplicableCommand
{

	/**
	 * @param Player   $player
	 * @param SetupMap $map
	 *
	 * @return
	 */
	public function apply(Player $player, SetupMap $map);
}