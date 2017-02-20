<?php

namespace Prokki\Warlight2BotTemplate\Command;


/**
 * Class SetupMapWastelandsCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SetupMapWastelandsListCommand extends ReceivableIntListCommand implements ApplicableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		/** @var \Prokki\Warlight2BotTemplate\Game\SetupMap $map */
		$map = $player->getMap();

		foreach( $this->_value as $_region_id )
		{
			$map->addWasteland($_region_id);
		}

		$map->getWastelands()->setLoaded();
	}

}