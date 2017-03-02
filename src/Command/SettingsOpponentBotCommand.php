<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot\Bot;

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
	public function apply(Bot $bot)
	{
		$bot->getEnvironment()->getPlayer()->setNameOpponent($this->_value);
	}
}