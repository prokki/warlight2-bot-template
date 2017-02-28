<?php

namespace Prokki\Warlight2BotTemplate\Test\Game;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Game\RegionArray;

class RegionArrayTest extends TestCase
{

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::getOffsets()
	 */
	public function testGetOffsets()
	{
		$regionArray = new RegionArray();

		self::assertEmpty($regionArray->getOffsets());

		$regionArray->offsetSet(1, 'a');
		$regionArray->offsetSet(4711, 'b');
		$regionArray->offsetSet('c', 'c');

		self::assertEquals([1, 4711, 'c'], $regionArray->getOffsets());
	}
}