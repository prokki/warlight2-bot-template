<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

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
		
		$environment->getMap()->finishAddingWasteland();
	}

}