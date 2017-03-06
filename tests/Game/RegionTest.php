<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;

use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionArray;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;

class RegionTest extends TestCase
{

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::__construct()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»getState()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getId()
	 */
	public function testConstruct()
	{
		$region = new Region(123456, new SuperRegion(4711, 1001001));

		self::assertEquals(RegionState::class, get_class($region->»getState()));
		self::assertEquals(RegionArray::class, get_class($region->getNeighbors()));
		self::assertEquals(123456, $region->getId());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::addNeighbor()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getNeighbors()
	 */
	public function testAddNeighbor()
	{
		$super_region = new SuperRegion(4711, 1001001);

		$region_1 = new Region(1, $super_region);
		$region_2 = new Region(2, $super_region);
		$region_3 = new Region(3, $super_region);
		$region_4 = new Region(4, $super_region);

		$region_1->addNeighbor($region_2);
		$region_1->addNeighbor($region_3);
		self::assertEquals(2, count($region_1->getNeighbors()));
		self::assertEquals(1, count($region_2->getNeighbors()));
		self::assertEquals(1, count($region_3->getNeighbors()));
		self::assertEquals(0, count($region_4->getNeighbors()));

		$region_4->addNeighbor($region_3, false);
		self::assertEquals(2, count($region_1->getNeighbors()));
		self::assertEquals(1, count($region_2->getNeighbors()));
		self::assertEquals(1, count($region_3->getNeighbors()));
		self::assertEquals(1, count($region_4->getNeighbors()));

		$region_3->addNeighbor($region_4, false);
		self::assertEquals(2, count($region_1->getNeighbors()));
		self::assertEquals(1, count($region_2->getNeighbors()));
		self::assertEquals(
			[
				1 => $region_1,
				4 => $region_4,
			],
			$region_3->getNeighbors()->getArrayCopy());
		self::assertEquals(1, count($region_4->getNeighbors()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::setWasteland()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::enableFog()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::disableFog()
	 */
	public function testSetWasteland()
	{
		$region = new Region(123456, new SuperRegion(4711, 1001001));
		self::assertEquals(2, $region->getArmies());

		$region->enableFog();
		self::assertEquals(1, $region->getArmies());
		self::assertEquals(RegionState::OWNER_UNKNOWN, $region->getOwner());

		$region->setWasteland();
		self::assertEquals(6, $region->getArmies());
		self::assertEquals(RegionState::OWNER_NEUTRAL, $region->getOwner());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::isFog()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::enableFog()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::isFog()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::setFog()
	 */
	public function testIsFog()
	{
		$region = new Region(123456, new SuperRegion(4711, 1001001));
		self::assertFalse($region->isFog());
		self::assertEquals(2, $region->getArmies());
		self::assertEquals(RegionState::OWNER_NEUTRAL, $region->getOwner());

		$region->enableFog();
		self::assertTrue($region->isFog());
		self::assertEquals(1, $region->getArmies());
		self::assertEquals(RegionState::OWNER_UNKNOWN, $region->getOwner());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getOwner()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::getOwner()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::setOwner()
	 */
	public function testGetOwner()
	{
		$region = new Region(123456, new SuperRegion(4711, 1001001));
		self::assertEquals(RegionState::OWNER_NEUTRAL, $region->getOwner());

		$region->»getState()->setOwner(RegionState::OWNER_OPPONENT);
		self::assertEquals(RegionState::OWNER_OPPONENT, $region->getOwner());

		// reset from OWNER_OPPONENT (and OWNER_ME) to NEUTRAL or UNKNOWN is not possible 
		$region->»getState()->setOwner(RegionState::OWNER_NEUTRAL);
		self::assertEquals(RegionState::OWNER_OPPONENT, $region->getOwner());
		$region->»getState()->setOwner(RegionState::OWNER_UNKNOWN);
		self::assertEquals(RegionState::OWNER_OPPONENT, $region->getOwner());

		// but a owner change to OWNER_ME (after an attack)
		$region->»getState()->setOwner(RegionState::OWNER_ME);
		self::assertEquals(RegionState::OWNER_ME, $region->getOwner());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getArmies()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::getArmies()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::setArmies()
	 */
	public function testGetArmies()
	{
		$region = new Region(123456, new SuperRegion(4711, 1001001));
		self::assertEquals(2, $region->getArmies());

		$region->»getState()->setArmies(2000000);
		self::assertEquals(2000000, $region->getArmies());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»assignSuperRegion()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getSuperRegion()
	 */
	public function testAssignSuperRegion()
	{
		$region = new Region(1);

		self::assertNull($region->getSuperRegion());

		$super_region = new SuperRegion(1, 5);
		$region->»assignSuperRegion($super_region);

		self::assertEquals($super_region, $region->getSuperRegion());
	}

}