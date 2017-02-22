<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

/**
 * Class PickStartingRegionCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class EmptySendCommand extends Command implements SendableCommand
{
	/**
	 * @inheritdoc
	 */
	public function compute($ai, Player $player, Map $map)
	{
		return '';
	}
}