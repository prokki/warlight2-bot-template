<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\Move\PickMove;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;
use Prokki\Warlight2BotTemplate\GamePlay\AIable;
use Prokki\Warlight2BotTemplate\Command\CommandParser;

class PickStartingRegionCommandTest extends CommandTest
{
	/**
	 * @return PickStartingRegionCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   pick_starting_region     1234567   3      4    	1  17   	');
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
		CommandParser::Init()->run('pick_starting_region');
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArgumentsOneArgument()
	{
		CommandParser::Init()->run('pick_starting_region     10000   ');
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
		$environment = new Environment();

		$environment->getPlayer()->setStartingRegions([3, 4, 1, 17, 5, 6]);

		$regions = $environment->getMap()->getRegions();

		$super_region = new SuperRegion(1, 7);

		for( $_i = 1; $_i <= 20; $_i++ )
		{
			$regions->offsetSet($_i, new Region($_i, $super_region));
		}

		$regions->offsetGet(6)->»getState()->setOwner(RegionState::OWNER_ME);

		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(5)->getOwner());
		self::assertEquals(RegionState::OWNER_ME, $regions->offsetGet(6)->getOwner());

		$this->_getTestCommand()->apply($environment);

		self::assertEquals(1234567, $environment->getPlayer()->getGlobalTime());
		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(5)->getOwner());
		self::assertEquals(RegionState::OWNER_ME, $regions->offsetGet(6)->getOwner());
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
		$environment = new Environment();
		$ai          = $this->createMock(AIable::class);

		$ai->method('getPickMove')->willReturn(new PickMove(3));

		$this->assertEquals(3, $this->_getTestCommand()->compute($ai, $environment));
	}
}