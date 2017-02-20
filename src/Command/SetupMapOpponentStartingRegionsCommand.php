<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\RegionState;

/**
 * Class SetupMapOpponentStartingRegionsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SetupMapOpponentStartingRegionsListCommand extends ReceivableIntListCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		/** @var \Prokki\Warlight2BotTemplate\Game\SetupMap $map */
		$map = $player->getMap();

		foreach( $this->_value as $_region_id )
		{
			$map->getRegion($_region_id)->getState()->setOwner(RegionState::OWNER_OPPONENT);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function isPrompt()
	{
		return false;
	}
}