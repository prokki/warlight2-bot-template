<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

/**
 * Class EmptyReceiveCommand
 *
 * @package Prokki\Warlight2BotTemplate
 */
class EmptyReceiveCommand extends Command
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, SetupMap $map)
	{

	}
}