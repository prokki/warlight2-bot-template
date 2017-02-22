<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

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
class SetupMapSuperRegionsCommand extends ReceivableTupleIntListCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, SetupMap $map)
	{
		foreach( $this->_value as $_id_super_region => $_bonus_armies )
		{
			$map->addSuperRegion($_id_super_region, $_bonus_armies);
		}

		$map->getSuperRegions()->setLoaded();
	}
}