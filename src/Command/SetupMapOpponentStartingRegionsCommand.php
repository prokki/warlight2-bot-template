<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\RegionState;

/**
 * Class SetupMapOpponentStartingRegionsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SetupMapOpponentStartingRegionsCommand extends ReceivableIntListCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, Map $map)
	{
		foreach( $this->_value as $_region_id )
		{
			$map->getRegion($_region_id)->getState()->setOwner(RegionState::OWNER_OPPONENT);
		}
	}
}