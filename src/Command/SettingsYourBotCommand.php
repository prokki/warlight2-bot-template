<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

/**
 * Class SettingsYourBotCommand to set/get the name of your bot.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SettingsYourBotCommand extends ReceivableStringCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Environment $environment)
	{
		$environment->getPlayer()->setName($this->_value);
	}

}