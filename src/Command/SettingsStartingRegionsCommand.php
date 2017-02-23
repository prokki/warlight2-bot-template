<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

/**
 * Class SettingsStartingRegionsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SettingsStartingRegionsCommand extends ReceivableIntListCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, Map $map)
	{
		$player->setStartingRegions($this->_value);
	}

}