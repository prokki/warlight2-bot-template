<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

/**
 * Class SettingsStartingRegionsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SettingsStartingRegionsCommand extends ReceivableIntListCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Environment $environment)
	{
		$environment->getPlayer()->setStartingRegions($this->_value);
	}

}