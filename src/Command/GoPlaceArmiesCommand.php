<?php

namespace Prokki\Warlight2BotTemplate\Command;

/**
 * Class PickStartingRegionCommand to initialize the super regions.
 *
 * @package Warlight2Bot\Command
 */
class GoPlaceArmiesCommand extends ReceivableIntCommand implements ApplicableCommand, SendableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->setGlobalTime($this->_value);
	}

	/**
	 * @inheritdoc
	 */
	public function compute($ai, $player)
	{
		return sprintf("%s place_armies %s", $player->getSetting()->getName(), implode(' ', $ai->getPlaceMoves($player)));
	}
}