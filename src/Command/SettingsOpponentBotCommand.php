<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

/**
 * Class SettingsYourBotCommand to set/get the name of your bot.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SettingsOpponentBotCommand extends SettingsYourBotCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, Map $map)
	{
		$player->setNameOpponent($this->_value);
	}
}