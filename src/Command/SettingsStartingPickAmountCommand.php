<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

class SettingsStartingPickAmountCommand extends ReceivableIntCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, Map $map)
	{
		$player->setStartingPickAmount($this->_value);
	}

}