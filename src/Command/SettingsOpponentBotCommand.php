<?php

namespace Prokki\Warlight2BotTemplate\Command;

/**
 * Class SettingsYourBotCommand to set/get the name of your bot.
 *
 * @package Warlight2Bot\Command
 */
class SettingsOpponentBotCommand extends SettingsYourBotCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->getSetting()->setNameOpponent($this->_value);
	}
}