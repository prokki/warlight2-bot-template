<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

class SettingsStartingArmiesCommand extends ReceivableIntCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Environment $environment)
	{
		$environment->getPlayer()->setStartingArmies($this->_value);
	}

}