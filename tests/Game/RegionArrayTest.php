<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\Game\RegionState;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionArray;
use Prokki\Warlight2BotTemplate\Test\MapTest;

class RegionArrayTest extends MapTest
{

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::getIds()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::addRegion()
	 */
	public function testGetIds()
	{
		$regions = new RegionArray();

		self::assertEmpty($regions);
		self::assertEmpty($regions->getIds());

		$regions->addRegion(new Region(4711));
		$regions->addRegion(new Region(815));

		self::assertEquals([4711, 815], $regions->getIds());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::get()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::hasRegion()
	 */
	public function testGet()
	{
		$regions = new RegionArray();

		$region_1 = new Region(4711);
		$region_2 = new Region(815);

		$regions->addRegion($region_1);
		$regions->addRegion($region_2);

		// super region with ID 815 exists
		self::assertTrue($regions->hasRegion(815));
		self::assertEquals($region_2, $regions->get(815));
		// super region with ID 1 does not exist
		self::assertFalse($regions->hasRegion(1));
		self::expectException(RuntimeException::class);
		self::expectExceptionCode(301);
		$regions->get(12345);
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::filterOwner()
	 */
	public function testFilterOwner()
	{
		self::assertEquals(9, count($this->_map->getRegions()->filterOwner(RegionState::OWNER_NEUTRAL)));
		self::assertEmpty($this->_map->getRegions()->filterOwner(RegionState::OWNER_ME));
	}
}