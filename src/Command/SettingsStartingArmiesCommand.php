<?php

namespace Prokki\Warlight2BotTemplate\Command;

class SettingsStartingArmiesCommand extends ReceivableIntCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->getSetting()->setStartingArmies($this->_value);
	}

}