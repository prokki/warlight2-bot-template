<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;
use Prokki\Warlight2BotTemplate\GamePlay\AIable;
use Prokki\Warlight2BotTemplate\Util\Parser;

class PickStartingRegionCommandTest extends CommandTest
{
	/**
	 * @return PickStartingRegionCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   pick_starting_region     1234567   3      4    	1  17   	');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(PickStartingRegionCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArguments()
	{
		Parser::Init()->run('pick_starting_region');
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArgumentsOneArgument()
	{
		Parser::Init()->run('pick_starting_region     10000   ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand::_setOpponentRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Player::setGlobalTime()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getStartingRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegion()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::getOwner()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new Map();

		$player->setStartingRegions([3, 4, 1, 17, 5, 6]);

		$regions = $map->getRegions();

		$super_region = new SuperRegion(1, 7);

		for( $_i = 1; $_i <= 20; $_i++ )
		{
			$regions->offsetSet($_i, new Region($_i, $super_region));
		}

		$regions->offsetGet(6)->getState()->setOwner(RegionState::OWNER_ME);

		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(5)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_ME, $regions->offsetGet(6)->getState()->getOwner());

		$this->_getTestCommand()->apply($player, $map);

		self::assertEquals(1234567, $player->getGlobalTime());
		self::assertEquals(RegionState::OWNER_OPPONENT, $regions->offsetGet(5)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_ME, $regions->offsetGet(6)->getState()->getOwner());
	}

	/**
	 * @inheritdoc
	 */
	public function testIsComputable()
	{
		self::assertTrue($this->_getTestCommand()->isComputable());
	}


	/**
	 * @inheritdoc
	 */
	public function testCompute()
	{
		$player = new Player();
		$map    = new SetupMap();
		$ai     = $this->createMock(AIable::class);

		$ai->method('pickStartingRegion')->willReturn(3);

		$this->assertEquals(3, $this->_getTestCommand()->compute($ai, $player, $map));
	}
}