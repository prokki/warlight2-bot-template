<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\UpdateMapCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;
use Prokki\Warlight2BotTemplate\Util\CommandParser;

class UpdateMapCommandTest extends CommandTest
{
	/**
	 * @return UpdateMapCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   update_map 1 player1 6 3 player2 2		4      neutral    7   	   ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(UpdateMapCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingTwoArguments()
	{
		CommandParser::Init()->run('update_map 1 player1');
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingOneArgument()
	{
		CommandParser::Init()->run('update_map 1 player1');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new Map();

		$super_region = new SuperRegion(1, 7);

		$player
			->setName('player1')
			->setNameOpponent('player2');

		$regions = $map->getRegions();

		for( $_i = 1; $_i <= 20; $_i++ )
		{
			$regions->offsetSet($_i, new Region($_i, $super_region));
		}

		$this->_getTestCommand()->apply($player, $map);

		self::assertEquals(RegionState::OWNER_ME, $map->getRegion(1)->getState()->getOwner());
		self::assertEquals(6, $map->getRegion(1)->getState()->getArmies());

		self::assertEquals(RegionState::OWNER_OPPONENT, $map->getRegion(3)->getState()->getOwner());
		self::assertEquals(2, $map->getRegion(3)->getState()->getArmies());

		self::assertEquals(RegionState::OWNER_NEUTRAL, $map->getRegion(4)->getState()->getOwner());
		self::assertEquals(7, $map->getRegion(4)->getState()->getArmies());
	}
}