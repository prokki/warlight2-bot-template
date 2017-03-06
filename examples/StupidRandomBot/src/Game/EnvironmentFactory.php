<?php

namespace Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\Game;

/**
 * Class EnvironmentFactory extends {@see \Prokki\Warlight2BotTemplate\Game\EnvironmentFactory}. This class represents the factory class to get new game objects.
 *
 * If you want to override existing template classes you have to
 * 1. call your (inherited) {@see \Prokki\TheaigamesBotEngine\Game\EnvironmentFactory::Init()} method to instantiate the singleton object and
 * 2. override the related new*() method(s).
 *
 * The StupidRandomBot uses just a custom map and custom regions states. Take a look at
 * {@see \Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\Game\Map} and {@see \Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\Game\RegionState}
 * for further information.
 *
 * @package Prokki\Warlight2BotTemplate\StupidRandomBot
 */
class EnvironmentFactory extends \Prokki\Warlight2BotTemplate\Game\EnvironmentFactory
{

	/**
	 * @inheritdoc
	 */
	public function newMap()
	{
		return new Map();
	}

	/**
	 * @inheritdoc
	 */
	public function newRegionState()
	{
		return new RegionState();
	}

}