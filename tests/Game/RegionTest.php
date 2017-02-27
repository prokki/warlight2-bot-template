<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;

use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;

class RegionTest extends TestCase
{

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::isFog()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»getState()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::isFog()
	 */
	public function testIsFog()
	{
		$region = new Region(1, 1);
		self::assertFalse($region->isFog());

		$region->»getState()->setFog(true);
		self::assertTrue($region->isFog());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getOwner()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»getState()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::setOwner()
	 */
	public function testGetOwner()
	{
		$region = new Region(1, 1);
		self::assertEquals(RegionState::OWNER_NEUTRAL, $region->getOwner());

		$region->»getState()->setOwner(RegionState::OWNER_OPPONENT);
		self::assertEquals(RegionState::OWNER_OPPONENT, $region->getOwner());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::getArmies()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»getState()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::setArmies()
	 */
	public function testGetArmies()
	{
		$region = new Region(1, 1);
		self::assertEquals(2, $region->getArmies());

		$region->»getState()->setArmies(2000000);
		self::assertEquals(2000000, $region->getArmies());
	}

}