<?php

namespace Prokki\Warlight2BotTemplate\Command;

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
	public function compute($player)
	{
		return '';
	}
}