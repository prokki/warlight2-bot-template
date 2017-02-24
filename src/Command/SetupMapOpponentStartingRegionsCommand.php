<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\Round;

/**
 * Class SetupMapOpponentStartingRegionsCommand handles
 * - the reception of the region ids the opponent player has chosen
 *
 * Request: `setup_map opponent_starting_regions [-i ...] ` with a whitespace separated list of all region ids
 *
 * Example:
 * ```
 * -> setup_map opponent_starting_regions 7 12 14
 * ```
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

		$environment->getCurrentRound()->setUpdatedMap(clone $environment->getMap());
	}
}