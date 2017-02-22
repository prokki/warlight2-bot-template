<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

/**
 * Class SettingsYourBotCommand to set/get the name of your bot.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SettingsYourBotCommand extends ReceivableStringCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, SetupMap $map)
	{
		$player->setName($this->_value);
	}

}