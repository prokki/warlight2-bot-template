<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use Prokki\Warlight2BotTemplate\Exception\InitializationException;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Move\PickMove;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionArray;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;
use Prokki\Warlight2BotTemplate\Game\SuperRegionArray;

class MapTest extends \Prokki\Warlight2BotTemplate\Test\MapTest
{

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeSuperRegions()
	 */
	public function testInitializeSuperRegions()
	{
		$this->assertAttributeInstanceOf(RegionArray::class, '_regions', $this->_map);
		$this->assertEquals(4, count($this->_map->getSuperRegions()->getArrayCopy()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::initialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::__construct()
	 */
	public function testInitialize()
	{
		// set _initialized to true to simulate a second _tryToInitialize
		$reflection_property = new \ReflectionProperty(SetupMap::class, '_initialized');
		$reflection_property->setAccessible(true);
		$this->assertTrue($reflection_property->getValue($this->_map));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::_initializeRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::hasSuperRegion()
	 */
	public function testInitializeRegions()
	{
		$this->assertAttributeInstanceOf(RegionArray::class, '_regions', $this->_map);
		$this->assertEquals(9, count($this->_map->getRegions()));
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
		self::assertEquals([1, 3, 5, 8], $this->_map->getRegion(4)->getNeighbors()->getIds());
		self::assertEquals([4], $this->_map->getRegion(3)->getNeighbors()->getIds());
		self::assertEquals([4, 5, 6, 9], $this->_map->getRegion(8)->getNeighbors()->getIds());
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
		$map->addNeighbors(12345, []);
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
		self::assertEquals(2, $this->_map->getRegion(1)->getArmies());
		self::assertEquals(6, $this->_map->getRegion(2)->getArmies());
		self::assertEquals(6, $this->_map->getRegion(4)->getArmies());

		// try to set wasteland to an unknown region with id 12345
		self::expectException(InitializationException::class);
		self::expectExceptionCode(203);
		$this->_map->addWasteland(12345);
		$this->_map->initialize();
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
		self::assertEquals(Region::class, get_class($this->_map->getRegion(6)));

		// region with id 12345 is not known
		self::expectException(RuntimeException::class);
		self::expectExceptionCode(301);
		self::assertEquals($this->_map->getRegion(12345));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegions()
	 */
	public function testGetRegions()
	{
		$map = new Map();
		self::assertEquals(RegionArray::class, get_class($map->getRegions()));

		self::assertEquals(RegionArray::class, get_class($this->_map->getRegions()));
		self::assertEquals(9, count($this->_map->getRegions()->filterOwner(RegionState::OWNER_NEUTRAL)));

		$this->_map->getRegion(1)->»getState()->setOwner(RegionState::OWNER_UNKNOWN);
		self::assertEquals(8, count($this->_map->getRegions()->filterOwner(RegionState::OWNER_NEUTRAL)));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getSuperRegions()
	 */
	public function testGetSuperRegions()
	{
		$map = new Map();
		self::assertEquals(SuperRegionArray::class, get_class($map->getSuperRegions()));

		self::assertEquals(SuperRegionArray::class, get_class($this->_map->getSuperRegions()));
		self::assertEquals(4, count($this->_map->getSuperRegions()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getSuperRegion()
	 */
	public function testGetSuperRegion()
	{
		self::assertEquals(SuperRegion::class, get_class($this->_map->getSuperRegion(1)));

		// super region with id 12345 is not known
		self::expectException(RuntimeException::class);
		self::expectExceptionCode(311);
		$this->_map->getSuperRegion(12345);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getUniqueOpponentPickMoves()
	 */
	public function testGetUniqueOpponentPickMoves()
	{
		foreach( $this->_map->getRegions() as $_region )
		{
			self::assertEquals(RegionState::OWNER_NEUTRAL, $_region->getOwner());
		}

		// two regions are picked => two pick moves are returned 
		self::assertEquals(
			[
				new PickMove(3),
				new PickMove(5),
			],
			$this->_map->getUniqueOpponentPickMoves([3, 5])
		);

		// already picked region are picked a second time => no moves are returned
		self::assertEmpty($this->_map->getUniqueOpponentPickMoves([3, 5]));

		// another region is picked => a single move is returned
		self::assertEquals(
			[new PickMove(2)],
			$this->_map->getUniqueOpponentPickMoves([2])
		);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::__clone()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»getState()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»setState()
	 */
	public function testClone()
	{
		$cloned_map = clone $this->_map;

		self::assertEquals($this->_map, $cloned_map);
		self::assertNotEquals(spl_object_hash($this->_map), spl_object_hash($cloned_map));
	}
}