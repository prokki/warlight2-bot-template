<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

class SettingsTimebankCommand extends ReceivableIntCommand
{

	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, Map $map)
	{
		$player->setTimebank($this->_value);
	}
}