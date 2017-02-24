<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

/**
 * A EmptyReceivableCommand command can be assigned to requests, that do not need to be handled.
 *
 * Normally this command class is for testing or new request commands.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class EmptyReceivableCommand extends Command
{
	/**
	 * The apply method is empty.
	 *
	 * @inheritdoc
	 */
	public function apply(Environment $environment) { }
}