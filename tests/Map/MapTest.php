<?php

namespace Prokki\Warlight2BotTemplate\Test\Map;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Test\Command\SetupMapOpponentStartingRegionsCommandTest;
use Prokki\Warlight2BotTemplate\Util\Parser;

class MapTest extends TestCase
{

	/**
	 */
	public function testGetRegion()
	{
		$map = new SetupMap();

		$map->addSuperRegion(1, 1);
		
		$map->addRegion(1, 1);
		$map->addRegion(2, 1);
		$map->addRegion(3, 1);
		$map->addRegion(4, 1);
		$map->addRegion(5, 1);
		$map->addRegion(6, 1);

		$map->initialize();

		$map->getRegion(1)->getState()->setOwner(RegionState::OWNER_UNKNOWN);
		$map->getRegion(2)->getState()->setOwner(RegionState::OWNER_NEUTRAL);
		$map->getRegion(3)->getState()->setOwner(RegionState::OWNER_ME);
		$map->getRegion(4)->getState()->setOwner(RegionState::OWNER_OPPONENT);
		$map->getRegion(5)->getState()->setOwner(RegionState::OWNER_OPPONENT);
		
		self::assertEquals(6, count($map->getRegions()));
		self::assertEquals(RegionState::OWNER_UNKNOWN, $map->getRegion(1)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_ME, $map->getRegion(3)->getState()->getOwner());
		self::assertEquals(1, count($map->getRegions(RegionState::OWNER_ME)));
		self::assertEquals(2, count($map->getRegions(RegionState::OWNER_OPPONENT)));
	}
}