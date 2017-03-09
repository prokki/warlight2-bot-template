<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\LoadedArray;
use Prokki\Warlight2BotTemplate\Exception\InitializationException;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

class SetupMapTest extends TestCase
{
	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addSuperRegionSetUp()
	 */
	public function testAdd()
	{
		$map = new SetupMap();
		$map->addSuperRegionSetUp(200, 0);
		$map->addSuperRegionSetUp(300, 7000);
		$map->addSuperRegionSetUp(400, 21000);

		$this->assertAttributeInstanceOf(LoadedArray::class, '_superRegionIds', $map);
		$this->assertEquals([200 => 0, 300 => 7000, 400 => 21000], $this->getObjectAttribute($map, '_superRegionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addSuperRegionSetUp()
	 */
	public function testAddTwice()
	{
		$map = new SetupMap();
		$map->addSuperRegionSetUp(200, 0);

		// add super region a second time throws an exception
		self::expectException(InitializationException::class);
		self::expectExceptionCode(221);
		$map->addSuperRegionSetUp(200, 7000);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addRegionSetUp()
	 */
	public function testAddRegion()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_regionIds', $map);

		$map->addRegionSetUp(1, 200);
		$map->addRegionSetUp(2, 200);
		$map->addRegionSetUp(3, 200);
		$map->addRegionSetUp(4, 300);
		$map->addRegionSetUp(5, 300);

		$this->assertEquals([200 => [1, 2, 3], 300 => [4, 5]], $this->getObjectAttribute($map, '_regionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addRegionSetUp()
	 */
	public function testAddRegionFailed()
	{
		$map = new SetupMap();
		$map->addRegionSetUp(4, 300);

		// add region a second time throws an exception
		self::expectException(InitializationException::class);
		self::expectExceptionCode(211);
		$map->addRegionSetUp(4, 300);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addNeighborsSetUp()
	 */
	public function testAddNeighbors()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_neighborRegionIds', $map);

		$map->addNeighborsSetUp(1, [2, 4]);
		$map->addNeighborsSetUp(3, [4, 5]);

		$this->assertEquals([1 => [2, 4], 3 => [4, 5]], $this->getObjectAttribute($map, '_neighborRegionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addNeighborsSetUp()
	 */
	public function testAddNeighborsTwice()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_neighborRegionIds', $map);

		$map->addNeighborsSetUp(1, [2, 4]);
		$map->addNeighborsSetUp(1, [2, 4]);
		$map->addNeighborsSetUp(3, [5]);
		$map->addNeighborsSetUp(3, [4, 5]);

		$this->assertEquals([1 => [2, 4], 3 => [5, 4]], $this->getObjectAttribute($map, '_neighborRegionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addNeighborsSetUp()
	 */
	public function testAddEmptyNeighbors()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_neighborRegionIds', $map);

		$map->addNeighborsSetUp(6, []);

		$this->assertEquals([6 => []], $this->getObjectAttribute($map, '_neighborRegionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addWastelandSetUp()
	 */
	public function testAddWasteland()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_wastelandIds', $map);

		$map->addWastelandSetUp(2);
		$map->addWastelandSetUp(5);
		$map->addWastelandSetUp(6);

		$this->assertEquals([2 => 2, 5 => 5, 6 => 6], $this->getObjectAttribute($map, '_wastelandIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addWastelandSetUp()
	 */
	public function testAddWastelandTwice()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_wastelandIds', $map);

		$map->addWastelandSetUp(2);
		$map->addWastelandSetUp(2);

		$this->assertEquals([2 => 2], $this->getObjectAttribute($map, '_wastelandIds')->getArrayCopy());
	}

//	/**
//	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::initialize()
//	 */
//	public function testInitialize()
//	{
//		$map = new SetupMap();
//		$this->assertFalse($map->initialize());
//	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::_tryToInitialize()
	 */
	public function testTryToInitialize()
	{
		$map = new SetupMap();

		$reflection_method = new \ReflectionMethod(SetupMap::class, '_tryToInitialize');
		$reflection_method->setAccessible(true);

		$this->assertFalse($reflection_method->invoke($map));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::_tryToInitialize()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::__construct()
	 */
	public function testTryToInitializeTwice()
	{
		$map = new SetupMap();

		$reflection_method = new \ReflectionMethod(SetupMap::class, '_tryToInitialize');
		$reflection_method->setAccessible(true);

		// set _initialized to true to simulate a second _tryToInitialize
		$reflection_property = new \ReflectionProperty(SetupMap::class, '_initialized');
		$reflection_property->setAccessible(true);
		$reflection_property->setValue($map, true);

		// test _tryToInitialize() throws Exception
		self::expectException(InitializationException::class);
		self::expectExceptionCode(202);
		$reflection_method->invoke($map);
	}
}