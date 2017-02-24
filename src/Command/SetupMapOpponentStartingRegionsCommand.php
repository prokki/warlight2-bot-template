<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;
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
	public function apply(Environment $environment)
	{
		foreach( $this->_value as $_region_id )
		{
			$environment->getMap()->getRegion($_region_id)->getState()->setOwner(RegionState::OWNER_OPPONENT);
		}
	}
}