<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapWastelandsCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Util\Parser;

class SetupMapWastelandsCommandTest extends CommandTest
{
	/**
	 * @return SetupMapWastelandsCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   setup_map   wastelands     1 3    	5 ');
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
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::getWastelands()
	 * @covers \Prokki\Warlight2BotTemplate\Util\LoadedArray::isLoaded()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new SetupMap();
		
		self::assertEmpty($map->getWastelands());
		self::assertFalse($map->getWastelands()->isLoaded());

		$this->_getTestCommand()->apply($player, $map);

		self::assertTrue($map->getWastelands()->isLoaded());
		self::assertEquals(3, count($map->getWastelands()));

		self::assertEmpty(array_diff($map->getWastelands()->getArrayCopy(), [5, 3, 1]));
		self::assertEmpty(array_diff([3, 1, 5], $map->getWastelands()->getArrayCopy()));
	}
}