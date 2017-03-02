<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Exception\InitializationException;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Move\PickMove;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionArray;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;

class MapTest extends TestCase
{

	/**
	 * Returns an initialized test map.
	 *
	 * @return Map
	 */
	protected function _getTestMap()
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
		$map->addRegion(6, 400);

		$map->addNeighbors(1, [2, 3, 5]);
		$map->addNeighbors(3, [4]);
		$map->addNeighbors(4, [5]);

		$map->addWasteland(2);
		$map->addWasteland(6);

		$map->initialize();

		return $map;
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeSuperRegions()
	 */
	public function testInitializeSuperRegions()
	{
		$map = $this->_getTestMap();

		$this->assertAttributeInstanceOf(RegionArray::class, '_regions', $map);
		$this->assertEquals(3, count($map->getSuperRegions()->getArrayCopy()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::initialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::__construct()
	 */
	public function testInitialize()
	{
		$map = $this->_getTestMap();

		// set _initialized to true to simulate a second _tryToInitialize
		$reflection_property = new \ReflectionProperty(SetupMap::class, '_initialized');
		$reflection_property->setAccessible(true);
		$this->assertTrue($reflection_property->getValue($map));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::hasSuperRegion()
	 */
	public function testInitializeRegions()
	{
		$map = $this->_getTestMap();

		$map->initialize();

		$this->assertAttributeInstanceOf(RegionArray::class, '_regions', $map);
		$this->assertEquals(6, count($map->getRegions()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeRegions()
	 */
	public function testInitializeRegionWithMissingSuperRegion()
	{
		$map = new Map();
		$map->addRegion(1, 200);

		// initialize a region wit a missing super region throws an error
		self::expectException(InitializationException::class);
		self::expectExceptionCode(203);
		$map->initialize();
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeNeighbors()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::hasRegion()
	 */
	public function testInitializeNeighbors()
	{
		$map = $this->_getTestMap();

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

		// initialize a region wit a missing super region throws an error
		self::expectException(InitializationException::class);
		self::expectExceptionCode(203);
		$map->addNeighbors(1, [7]);
		$map->initialize();
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeNeighbors()
	 */
	public function testInitializeNeighborsWithUnknownRegion()
	{
		$map = new Map();

		// initialize a region wit a missing super region throws an error
		self::expectException(InitializationException::class);
		self::expectExceptionCode(203);
		$map->addNeighbors(1, []);
		$map->initialize();
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeNeighbors()
	 */
	public function testInitializeNeighborsWithUnknownNeighborRegion()
	{
		$map = new Map();
		$map->addSuperRegion(200, 0);
		$map->addRegion(1, 200);

		// initialize a region wit a missing super region throws an error
		self::expectException(InitializationException::class);
		self::expectExceptionCode(203);
		$map->addNeighbors(1, [2]);
		$map->initialize();
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeWastelands()
	 */
	public function testInitializeWastelands()
	{
		$map = $this->_getTestMap();

		self::assertEquals(2, $map->getRegion(1)->getArmies());
		self::assertEquals(6, $map->getRegion(2)->getArmies());
		self::assertEquals(6, $map->getRegion(6)->getArmies());

		// initialize an unknown region
		self::expectException(InitializationException::class);
		self::expectExceptionCode(203);
		$map->addWasteland(7);
		$map->initialize();
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::_tryToInitialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::finishAddingRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::finishAddingSuperRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::finishAddingNeighbors()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::finishAddingWasteland()
	 */
	public function testTryToInitialize()
	{
		$map = new Map();

		$reflection_method = new \ReflectionMethod(SetupMap::class, '_tryToInitialize');
		$reflection_method->setAccessible(true);

		$this->assertFalse($reflection_method->invoke($map));

		$map->finishAddingRegions();
		$this->assertFalse($reflection_method->invoke($map));

		$map->finishAddingSuperRegions();
		$this->assertFalse($reflection_method->invoke($map));

		$map->finishAddingNeighbors();
		$this->assertFalse($reflection_method->invoke($map));

		// finishAddingWasteland() executes _tryToInitialize
		$map->finishAddingWasteland();

		// a second call to _tryToInitialize throws an exception
		self::expectException(InitializationException::class);
		self::expectExceptionCode(202);
		$reflection_method->invoke($map);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegion()
	 */
	public function testGetRegion()
	{
		$map = $this->_getTestMap();

		self::assertEquals(Region::class, get_class($map->getRegion(6)));

		// region with id 7 is not known
		self::expectException(RuntimeException::class);
		self::expectExceptionCode(301);
		self::assertEquals($map->getRegion(7));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegions()
	 */
	public function testGetRegions()
	{
		$map = new Map();
		self::assertEquals(RegionArray::class, get_class($map->getRegions()));

		$map = $this->_getTestMap();
		self::assertEquals(RegionArray::class, get_class($map->getRegions()));
		self::assertEquals(6, count($map->getRegions(RegionState::OWNER_NEUTRAL)));

		$map->getRegion(1)->»getState()->setOwner(RegionState::OWNER_UNKNOWN);
		self::assertEquals(5, count($map->getRegions(RegionState::OWNER_NEUTRAL)));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getSuperRegions()
	 */
	public function testGetSuperRegions()
	{
		$map = new Map();
		self::assertEquals(RegionArray::class, get_class($map->getSuperRegions()));

		$map = $this->_getTestMap();
		self::assertEquals(RegionArray::class, get_class($map->getSuperRegions()));
		self::assertEquals(3, count($map->getSuperRegions()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getSuperRegion()
	 */
	public function testGetSuperRegion()
	{
		$map = $this->_getTestMap();
		self::assertEquals(SuperRegion::class, get_class($map->getSuperRegion(200)));

		// super region with id 12345 is not known
		self::expectException(RuntimeException::class);
		self::expectExceptionCode(311);
		self::assertEquals($map->getSuperRegion(12345));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getUniqueOpponentPickMoves()
	 */
	public function testGetUniqueOpponentPickMoves()
	{
		$map = $this->_getTestMap();

		for( $i = 1; $i <= 6; $i++ )
		{
			self::assertEquals(RegionState::OWNER_NEUTRAL, $map->getRegion(3)->getOwner());
		}

		// two regions are picked => two pick moves are returned 
		self::assertEquals(
			[
				new PickMove(3),
				new PickMove(5),
			],
			$map->getUniqueOpponentPickMoves([3, 5])
		);

		// already picked region are picked a second time => no moves are returned
		self::assertEmpty($map->getUniqueOpponentPickMoves([3, 5]));

		// another region is picked => a single move is returned
		self::assertEquals(
			[new PickMove(2)],
			$map->getUniqueOpponentPickMoves([2])
		);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::__clone()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»getState()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»setState()
	 */
	public function testClone()
	{
		$map = $this->_getTestMap();

		$cloned_map = clone $map;

		self::assertEquals($map, $cloned_map);
		self::assertNotEquals(spl_object_hash($map), spl_object_hash($cloned_map));
	}
}