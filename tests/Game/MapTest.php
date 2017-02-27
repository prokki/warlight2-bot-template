<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Exception\InitializationException;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionArray;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;

class MapTest extends TestCase
{
	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::initialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeSuperRegions()
	 */
	public function testInitializeSuperRegions()
	{
		$map = new Map();
		$map->addSuperRegion(200, 0);
		$map->addSuperRegion(300, 7000);
		$map->addSuperRegion(400, 21000);

		$map->initialize();

		$this->assertAttributeInstanceOf(RegionArray::class, '_regions', $map);
		$this->assertEquals(
			[
				200 => new SuperRegion(200, 0),
				300 => new SuperRegion(300, 7000),
				400 => new SuperRegion(400, 21000),
			],
			$map->getSuperRegions()->getArrayCopy()
		);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::initialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeRegions()
	 */
	public function testInitializeRegions()
	{
		$map = new Map();
		$map->addSuperRegion(200, 0);
		$map->addSuperRegion(300, 7000);
		$map->addSuperRegion(400, 21000);

		$map->addRegion(1, 200);
		$map->addRegion(2, 200);
		$map->addRegion(1234, 300);

		$map->initialize();

		$this->assertAttributeInstanceOf(RegionArray::class, '_regions', $map);
		$this->assertEquals(
			[
				1    => new Region(1, $map->getSuperRegion(200)),
				2    => new Region(2, $map->getSuperRegion(200)),
				1234 => new Region(1234, $map->getSuperRegion(300)),
			],
			$map->getRegions()->getArrayCopy()
		);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::initialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeRegions()
	 */
	public function testInitializeRegionWithMissingSuperRegion()
	{
		$map = new Map();
		$map->addRegion(1, 200);

		// initialize a region wit a missing super region throws an error
		$this->expectException(InitializationException::class);
		$this->expectExceptionCode(202);
		$map->initialize();
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::initialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeNeighbors()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegion()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getNeighbors()
	 */
	public function testInitializeNeighbors()
	{
		$map = new Map();

		$map->addSuperRegion(200, 0);
		$map->addSuperRegion(300, 7000);
		$map->addSuperRegion(400, 21000);

		$map->addRegion(1, 200);
		$map->addRegion(2, 200);
		$map->addRegion(3, 300);
		$map->addRegion(4, 300);
		$map->addRegion(5, 300);
		$map->addRegion(6, 300);

		$map->addNeighbors(1, [2, 3, 5]);
		$map->addNeighbors(3, [4]);
		$map->addNeighbors(4, [5]);

		$map->initialize();

		$neighbors_1 = $map->getRegion(1)->getNeighbors()->getArrayCopy();
		self::assertEquals([2, 3, 5], array_keys($neighbors_1));
		$neighbors_2 = $map->getRegion(2)->getNeighbors()->getArrayCopy();
		self::assertEquals([1], array_keys($neighbors_2));
		$neighbors_3 = $map->getRegion(3)->getNeighbors()->getArrayCopy();
		self::assertEquals([1, 4], array_keys($neighbors_3));
		$neighbors_4 = $map->getRegion(4)->getNeighbors()->getArrayCopy();
		self::assertEquals([3, 5], array_keys($neighbors_4));
		$neighbors_5 = $map->getRegion(5)->getNeighbors()->getArrayCopy();
		self::assertEquals([1, 4], array_keys($neighbors_5));
		$neighbors_6 = $map->getRegion(6)->getNeighbors()->getArrayCopy();
		self::assertEmpty($neighbors_6);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::initialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeWastelands()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getArmies()
	 */
	public function testInitializeWastelands()
	{
		$map = new Map();

		$map->addSuperRegion(200, 0);
		$map->addSuperRegion(300, 7000);
		$map->addSuperRegion(400, 21000);

		$map->addRegion(1, 200);
		$map->addRegion(2, 200);
		$map->addRegion(3, 300);
		$map->addRegion(4, 300);
		$map->addRegion(5, 300);
		$map->addRegion(6, 300);

		$map->addWasteland(2);
		$map->addWasteland(6);

		$map->initialize();

		self::assertEquals(2, $map->getRegion(1)->getArmies());
		self::assertEquals(6, $map->getRegion(2)->getArmies());
		self::assertEquals(2, $map->getRegion(3)->getArmies());
		self::assertEquals(2, $map->getRegion(4)->getArmies());
		self::assertEquals(2, $map->getRegion(5)->getArmies());
		self::assertEquals(6, $map->getRegion(6)->getArmies());
	}

}