<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

/**
 * Class SettingsYourBotCommand to set/get the name of your bot.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SettingsOpponentBotCommand extends SettingsYourBotCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Environment $environment)
	{
		$environment->getPlayer()->setNameOpponent($this->_value);
	}
}