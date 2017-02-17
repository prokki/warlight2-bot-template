<?php

namespace Prokki\Warlight2BotTemplate\Command;


class SettingsStartingPickAmountCommand extends ReceivableIntCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->getSetting()->setStartingPickAmount($this->_value);
	}

}