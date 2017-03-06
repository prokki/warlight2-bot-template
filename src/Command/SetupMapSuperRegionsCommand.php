<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot;

/**
 * Class SetupMapSuperRegionsCommand handles the initialization of super regions.
 *
 * Request: `setup_map super_regions [-i -i ...]` with id of super region and bonus armies for the occupied super region
 *
 * Example: Two super regions: the first one with id 1 has a bonus value of 2, the second one with id 2 has a bonus value of 5.
 * ```
 * -> go super_regions 1 2 2 5
 * ```
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SetupMapSuperRegionsCommand extends ReceivableTupleIntListCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		foreach( $this->_value as $_id_super_region => $_bonus_armies )
		{
			$bot->getEnvironment()->getMap()->addSuperRegion($_id_super_region, $_bonus_armies);
		}

		if( $bot->getEnvironment()->getMap()->finishAddingSuperRegions() )
		{
			$bot->getEnvironment()->getCurrentRound()->setInitialMap(clone $bot->getEnvironment()->getMap());
		}
	}
}