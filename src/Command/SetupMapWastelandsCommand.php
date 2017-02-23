<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

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
	public function apply(Player $player, Map $map)
	{
		foreach( $this->_value as $_region_id )
		{
			$map->addWasteland($_region_id);
		}

		$map->getWastelands()->setLoaded();
	}

}