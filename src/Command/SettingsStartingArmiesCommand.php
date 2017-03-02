<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot\Bot;

class SettingsStartingArmiesCommand extends ReceivableIntCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		$bot->getEnvironment()->getPlayer()->setStartingArmies($this->_value);
	}

}