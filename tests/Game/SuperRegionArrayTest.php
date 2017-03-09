<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;
use Prokki\Warlight2BotTemplate\Game\SuperRegionArray;

class SuperRegionArrayTest extends TestCase
{
	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegionArray::getIds()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegionArray::add()
	 */
	public function testGetIds()
	{	
		$super_regions = new SuperRegionArray();

		self::assertEmpty($super_regions);
		self::assertEmpty($super_regions->getIds());

		$super_regions->add(new SuperRegion(4711, 20));
		$super_regions->add(new SuperRegion(815, 13));

		self::assertEquals([4711, 815], $super_regions->getIds());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegionArray::get()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegionArray::has()
	 */
	public function testGet()
	{
		$super_regions = new SuperRegionArray();

		$super_region_1 = new SuperRegion(4711, 20);
		$super_region_2 = new SuperRegion(815, 13);

		$super_regions->add($super_region_1);
		$super_regions->add($super_region_2);

		// super region with ID 815 exists
		self::assertTrue($super_regions->has(815));
		self::assertEquals($super_region_2, $super_regions->get(815));
		// super region with ID 1 does not exist
		self::assertFalse($super_regions->has(1));
		self::expectException(RuntimeException::class);
		self::expectExceptionCode(311);
		$super_regions->get(1);
	}
}