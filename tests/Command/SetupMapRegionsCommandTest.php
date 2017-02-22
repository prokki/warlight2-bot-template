<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapRegionsCommand;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SetupMapRegionsCommandTest extends CommandTest
{
	/**
	 * @return SetupMapRegionsCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   setup_map   regions     1   25	17    3      4    1');
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function testIsApplicable()
	{
		self::assertTrue($this->_getTestCommand()->isApplicable());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableTupleIntListCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapRegionsCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\ReceivableTupleIntListCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArguments()
	{
		Parser::Init()->run('setup_map regions 1 25	17 3 4 1 3   ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapRegionsCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableTupleIntListCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addRegion()
	 * @covers \Prokki\Warlight2BotTemplate\Util\LoadedArray::isLoaded()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new SetupMap();

		self::assertEmpty($map->getRegions());
		self::assertFalse($map->getRegions()->isLoaded());

		$this->_getTestCommand()->apply($player, $map);

		self::assertTrue($map->getRegions()->isLoaded());
		self::assertEquals(3, count($map->getRegions()));
		self::assertArrayHasKey(1, $map->getRegions());
		self::assertTrue($map->getRegions()->offsetExists(17));
		self::assertTrue($map->getRegions()->offsetExists(4));
	}
}