<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\LoadedArray;
use Prokki\Warlight2BotTemplate\Exception\InitializationException;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

class SetupMapTest extends TestCase
{
	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addSuperRegion()
	 */
	public function testAddSuperRegion()
	{
		$map = new SetupMap();
		$map->addSuperRegion(200, 0);
		$map->addSuperRegion(300, 7000);
		$map->addSuperRegion(400, 21000);

		$this->assertAttributeInstanceOf(LoadedArray::class, '_superRegionIds', $map);
		$this->assertEquals([200 => 0, 300 => 7000, 400 => 21000], $this->getObjectAttribute($map, '_superRegionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addSuperRegion()
	 */
	public function testAddSuperRegionTwice()
	{
		$map = new SetupMap();
		$map->addSuperRegion(200, 0);

		// add super region a second time throws an exception
		self::expectException(InitializationException::class);
		self::expectExceptionCode(221);
		$map->addSuperRegion(200, 7000);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addRegion()
	 */
	public function testAddRegion()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_regionIds', $map);

		$map->addRegion(1, 200);
		$map->addRegion(2, 200);
		$map->addRegion(3, 200);
		$map->addRegion(4, 300);
		$map->addRegion(5, 300);

		$this->assertEquals([200 => [1, 2, 3], 300 => [4, 5]], $this->getObjectAttribute($map, '_regionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addRegion()
	 */
	public function testAddRegionFailed()
	{
		$map = new SetupMap();
		$map->addRegion(4, 300);

		// add region a second time throws an exception
		self::expectException(InitializationException::class);
		self::expectExceptionCode(211);
		$map->addRegion(4, 300);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addNeighbors()
	 */
	public function testAddNeighbors()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_neighborRegionIds', $map);

		$map->addNeighbors(1, [2, 4]);
		$map->addNeighbors(3, [4, 5]);

		$this->assertEquals([1 => [2, 4], 3 => [4, 5]], $this->getObjectAttribute($map, '_neighborRegionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addNeighbors()
	 */
	public function testAddNeighborsTwice()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_neighborRegionIds', $map);

		$map->addNeighbors(1, [2, 4]);
		$map->addNeighbors(1, [2, 4]);
		$map->addNeighbors(3, [5]);
		$map->addNeighbors(3, [4, 5]);

		$this->assertEquals([1 => [2, 4], 3 => [5, 4]], $this->getObjectAttribute($map, '_neighborRegionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addNeighbors()
	 */
	public function testAddEmptyNeighbors()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_neighborRegionIds', $map);

		$map->addNeighbors(6, []);

		$this->assertEquals([6 => []], $this->getObjectAttribute($map, '_neighborRegionIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addWasteland()
	 */
	public function testAddWasteland()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_wastelandIds', $map);

		$map->addWasteland(2);
		$map->addWasteland(5);
		$map->addWasteland(6);

		$this->assertEquals([2 => 2, 5 => 5, 6 => 6], $this->getObjectAttribute($map, '_wastelandIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addWasteland()
	 */
	public function testAddWastelandTwice()
	{
		$map = new SetupMap();

		$this->assertAttributeInstanceOf(LoadedArray::class, '_wastelandIds', $map);

		$map->addWasteland(2);
		$map->addWasteland(2);

		$this->assertEquals([2 => 2], $this->getObjectAttribute($map, '_wastelandIds')->getArrayCopy());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::initialize()
	 */
	public function testInitialize()
	{
		$map = new SetupMap();
		$this->assertFalse($map->initialize());
	}

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