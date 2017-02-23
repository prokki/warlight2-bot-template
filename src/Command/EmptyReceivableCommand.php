<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

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
	public function apply(Player $player, Map $map) { }
}