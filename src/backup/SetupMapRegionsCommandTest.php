<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapRegionsCommand;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Command\CommandParser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SetupMapRegionsCommandTest extends CommandTest
{
	/**
	 * @return SetupMapRegionsCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   setup_map   regions     1   25	17    3      4    1');
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
		CommandParser::Init()->run('setup_map regions 1 25	17 3 4 1 3   ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapRegionsCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableTupleIntListCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::isLoaded()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addRegion()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEmpty($environment->getMap()->getRegions());
		self::assertFalse($environment->getMap()->getRegions()->isLoaded());

		$this->_getTestCommand()->apply($environment);

		self::assertTrue($environment->getMap()->getRegions()->isLoaded());
		self::assertEquals(3, count($environment->getMap()->getRegions()));
		self::assertArrayHasKey(1, $environment->getMap()->getRegions());
		self::assertTrue($environment->getMap()->getRegions()->offsetExists(17));
		self::assertTrue($environment->getMap()->getRegions()->offsetExists(4));
	}
}