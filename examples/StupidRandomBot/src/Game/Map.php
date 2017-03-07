<?php

namespace Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\Game;

/**
 * Class Map extends {@see \Prokki\Warlight2BotTemplate\Game\Map} with new features/behaviours.
 * You can add custom properties and methods to call them from your bot or by overridden Map methods.
 * *Remember* to include a factory class {@see EnvironmentFactory} to override method {@see \Prokki\Warlight2BotTemplate\Game\EnvironmentFactory::newMap()}.
 *
 * The most important feature of the StupidRandomBot's map is the weather update of each region at the beginning of each round :-)
 *
 * @package Prokki\Warlight2BotTemplate\StupidRandomBot
 */
class Map extends \Prokki\Warlight2BotTemplate\Game\Map
{
	/**
	 * Recalculates map state, region states, super region states, etc. at the beginning of each round.
	 */
	public function initialize()
	{
		if( !parent::initialize() )
		{
			return false;
		}

		foreach( $this->getRegions() as $_region )
		{
			/** @var RegionState $_region_state */
			$_region_state = $_region->»getState();

			$_region_state->updateWeather();
		}

		return true;
	}
}