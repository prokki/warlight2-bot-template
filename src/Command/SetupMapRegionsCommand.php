<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot;

/**
 * Class SetupMapSuperRegionsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 *
 *             * the super regions as associative array:
 *
 * the key is the id of the super region,
 * the value the bonus armies rewarded
 */
class SetupMapRegionsCommand extends ReceivableTupleIntListCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		foreach( $this->_value as $_id_region => $_id_super_region )
		{
			$bot->getEnvironment()->getMap()->addRegion($_id_region, $_id_super_region);
		}

		if( $bot->getEnvironment()->getMap()->finishAddingRegions() )
		{
			$bot->getEnvironment()->getCurrentRound()->setInitialMap(clone $bot->getEnvironment()->getMap());
		}
	}

}