<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapOpponentStartingRegionsCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Command\CommandParser;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;

class SetupMapOpponentStartingRegionsCommandTest extends CommandTest
{
	/**
	 * @return SetupMapOpponentStartingRegionsCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   setup_map   opponent_starting_regions     17			3');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntListCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapOpponentStartingRegionsCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapOpponentStartingRegionsCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntListCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Region::»getState()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::getOwner()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionState::setOwner()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		$regions = $environment->getMap()->getRegions();

		$super_region = new SuperRegion(1, 7);

		for( $_i = 1; $_i <= 20; $_i++ )
		{
			$regions->offsetSet($_i, new Region($_i, $super_region));
		}

		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(3)->getOwner());
		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(5)->getOwner());
		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(17)->getOwner());

//		$this->_getTestCommand()->apply($environment);
//
//		self::assertEquals(RegionState::OWNER_OPPONENT, $regions->offsetGet(3)->getOwner());
//		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(5)->getOwner());
//		self::assertEquals(RegionState::OWNER_OPPONENT, $regions->offsetGet(17)->getOwner());
	}
}