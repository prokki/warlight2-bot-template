<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

class SettingsStartingArmiesCommand extends ReceivableIntCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, SetupMap $map)
	{
		$player->setStartingArmies($this->_value);
	}

}