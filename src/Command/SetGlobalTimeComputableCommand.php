<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot\Bot;
use Prokki\TheaigamesBotEngine\Command\Computable;

/**
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class SetGlobalTimeComputableCommand extends ReceivableIntCommand implements Computable
{
	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		$bot->getEnvironment()->getPlayer()->setGlobalTime($this->_value);
	}

}