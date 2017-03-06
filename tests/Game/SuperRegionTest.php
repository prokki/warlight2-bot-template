<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;

class SuperRegionTest extends TestCase
{
	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegion::__construct()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegion::getId()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegion::getBonusArmies()
	 */
	public function testSuperRegion()
	{
		$super_region = new SuperRegion(12, 9999);

		self::assertEquals(12, $super_region->getId());
		self::assertEquals(9999, $super_region->getBonusArmies());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegion::getRegions()
	 */
	public function testAddRegion()
	{
		$map = new Map();

		$map->addSuperRegionSetUp(12, 9999);
		$map->addRegionSetUp(456, 12);
		$map->addRegionSetUp(123, 12);

		$map->initialize();

		self::assertEquals(2, count($map->getSuperRegion(12)->getRegions()));
		self::assertEquals([456, 123], $map->getSuperRegion(12)->getRegions()->getIds());
	}
}