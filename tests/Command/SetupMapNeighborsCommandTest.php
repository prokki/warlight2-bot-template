<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapNeighborsCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SetupMapNeighborsCommandTest extends CommandTest
{
	/**
	 * @return SetupMapNeighborsCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   setup_map   neighbors     1 2,3, 4 , 6 2 3 4    5,6   ');
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
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapNeighborsCommand::_parseArguments()
	 * 
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapNeighborsCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapNeighborsCommand::_parseArguments()
	 * 
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArguments()
	{
		Parser::Init()->run('setup_map neighbors 1 2,3,4 2');
	}
	
	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapNeighborsCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapNeighborsCommand::_parseArguments()
	 * 
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();

		/** @var \Warlight2BotTemplate\Map\SetupMap $map */
		$map = $player->getMap();
		self::assertEmpty($map->getNeighbors());
		self::assertFalse($map->getNeighbors()->isLoaded());

		$this->_getTestCommand()->apply($player);

		self::assertTrue($map->getNeighbors()->isLoaded());
		self::assertEquals(3, count($map->getNeighbors()));
		self::assertArrayHasKey(1, $map->getNeighbors());
		self::assertTrue($map->getNeighbors()->offsetExists(2));
		self::assertTrue($map->getNeighbors()->offsetExists(4));
	}
}