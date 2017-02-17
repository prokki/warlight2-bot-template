<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapOpponentStartingRegionsListCommand;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SetupMapOpponentStartingRegionsCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SetupMapWastelandsListCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   setup_map   opponent_starting_regions     17			3');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapOpponentStartingRegionsListCommand::class, get_class($this->_getTestCommand()));
	}
	
	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();

		$regions = $player->getMap()->getRegions();

		for( $_i = 1; $_i <= 20; $_i++ )
		{
			$regions->offsetSet($_i, new Region($_i));
		}

		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(3)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(5)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(17)->getState()->getOwner());

		$this->_getTestCommand()->apply($player);

		self::assertEquals(RegionState::OWNER_OPPONENT, $regions->offsetGet(3)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_NEUTRAL, $regions->offsetGet(5)->getState()->getOwner());
		self::assertEquals(RegionState::OWNER_OPPONENT, $regions->offsetGet(17)->getState()->getOwner());
	}
}