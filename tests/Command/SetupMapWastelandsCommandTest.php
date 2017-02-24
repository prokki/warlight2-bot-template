<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapWastelandsCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Util\CommandParser;

class SetupMapWastelandsCommandTest extends CommandTest
{
	/**
	 * @return SetupMapWastelandsCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   setup_map   wastelands     1 3    	5 ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntListCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapWastelandsCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapWastelandsCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntListCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::isLoaded()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::getWastelands()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new Map();
		
		self::assertEmpty($map->getWastelands());
		self::assertFalse($map->getWastelands()->isLoaded());

		$this->_getTestCommand()->apply($player, $map);

		self::assertTrue($map->getWastelands()->isLoaded());
		self::assertEquals(3, count($map->getWastelands()));

		self::assertEmpty(array_diff($map->getWastelands()->getArrayCopy(), [5, 3, 1]));
		self::assertEmpty(array_diff([3, 1, 5], $map->getWastelands()->getArrayCopy()));
	}
}