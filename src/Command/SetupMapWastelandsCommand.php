<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot;

/**
 * Class SetupMapWastelandsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SetupMapWastelandsCommand extends ReceivableIntListCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		foreach( $this->_value as $_region_id )
		{
			$bot->getEnvironment()->getMap()->addWastelandSetUp($_region_id);
		}

		if( $bot->getEnvironment()->getMap()->finishAddingWasteland() )
		{
			$bot->getEnvironment()->getCurrentRound()->setInitialMap(clone $bot->getEnvironment()->getMap());
		}
	}

}