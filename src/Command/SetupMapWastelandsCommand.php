<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\Round;

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
	public function apply(Environment $environment)
	{
		foreach( $this->_value as $_region_id )
		{
			$environment->getMap()->addWasteland($_region_id);
		}

		if( $environment->getMap()->finishAddingWasteland() )
		{
			$environment->getCurrentRound()->setInitialMap(clone $environment->getMap());
		}
	}

}