<?php

namespace Prokki\Warlight2BotTemplate\Command;

class SettingsTimebankCommand extends ReceivableIntCommand implements ApplicableCommand
{

	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->getSetting()->setTimebank($this->_value);
	}
}