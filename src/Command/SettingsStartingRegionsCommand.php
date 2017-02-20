<?php

namespace Prokki\Warlight2BotTemplate\Command;


/**
 * Class SettingsStartingRegionsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SettingsStartingRegionsListCommand extends ReceivableIntListCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->getSetting()->setStartingRegions($this->_value);
	}

}