<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

class SettingsTimebankCommand extends ReceivableIntCommand
{

	/**
	 * @inheritdoc
	 */
	public function apply(Environment $environment)
	{
		$environment->getPlayer()->setTimebank($this->_value);
	}
}