<?php

namespace Prokki\Warlight2BotTemplate\Command;

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
	public function apply($player)
	{
		$player->getSetting()->setName($this->_value);
	}

}