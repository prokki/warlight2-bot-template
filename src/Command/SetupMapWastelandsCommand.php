<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

/**
 * Class SetupMapWastelandsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SetupMapWastelandsCommand extends ReceivableIntListCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, SetupMap $map)
	{
		foreach( $this->_value as $_region_id )
		{
			$map->addWasteland($_region_id);
		}

		$map->getWastelands()->setLoaded();
	}

}