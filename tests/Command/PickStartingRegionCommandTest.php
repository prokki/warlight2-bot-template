<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand;
use Prokki\Warlight2BotTemplate\Command\SendableCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Util\Parser;

class PickStartingRegionCommandTest extends CommandTest
{
	/**
	 * @return PickStartingRegionCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   pick_starting_region     10000   3      4    	1  17   	');
	}

	/**
	 * @inheritdoc
	 */
	public function testIsApplicable()
	{
		self::assertTrue($this->_getTestCommand()->isApplicable());
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
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setStartingRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::getRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::getOwner()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();

		$player->getSetting()->setStartingRegions([3, 4, 1, 17, 5, 6]);

		$regions = $player->getMap()->getRegions();

		for( $_i = 1; $_i <= 20; $_i++ )
		{
			$regions->offsetSet($_i, new Region($_i));
		}

		$regions->offsetGet(6)->getState()->setOwner(RegionState::OWNER_ME);

		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(5)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_ME, $regions->offsetGet(6)->getState()->getOwner());

		$this->_getTestCommand()->apply($player);

		self::assertEquals(RegionState::OWNER_OPPONENT, $regions->offsetGet(5)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_ME, $regions->offsetGet(6)->getState()->getOwner());
	}
}