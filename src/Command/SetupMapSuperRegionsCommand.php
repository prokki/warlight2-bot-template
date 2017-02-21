<?php

namespace Prokki\Warlight2BotTemplate\Command;

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
class SetupMapSuperRegionsCommand extends ReceivableTupleIntListCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		/** @var \Prokki\Warlight2BotTemplate\Game\SetupMap $map */
		$map = $player->getMap();

		foreach( $this->_value as $_id_super_region => $_bonus_armies )
		{
			$map->addSuperRegion($_id_super_region, $_bonus_armies);
		}

		$map->getSuperRegions()->setLoaded();
	}
}