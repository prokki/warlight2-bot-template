<?php

namespace Prokki\Warlight2BotTemplate\Command;

/**
 * Class SettingsYourBotCommand to set/get the name of your bot.
 *
 * @package Warlight2Bot\Command
 */
class SettingsMaxRoundsCommand extends ReceivableIntCommand implements ApplicableCommand
{
	/**
	 * /**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->getSetting()->setMaxRounds($this->_value);
	}

}