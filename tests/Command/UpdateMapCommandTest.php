<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\UpdateMapCommand;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class UpdateMapCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   update_map 1 player1 6 3 player2 2		4      neutral    7   	   ');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(UpdateMapCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingTwoArguments()
	{
		Parser::Init()->run('update_map 1 player1');
	}

	/**
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingOneArgument()
	{
		Parser::Init()->run('update_map 1 player1');
	}

	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$player->getSetting()
			->setName('player1')
			->setNameOpponent('player2');

		$regions = $player->getMap()->getRegions();

		for( $_i = 1; $_i <= 20; $_i++ )
		{
			$regions->offsetSet($_i, new Region($_i));
		}

		$this->_getTestCommand()->apply($player);

		self::assertEquals(RegionState::OWNER_ME, $player->getMap()->getRegion(1)->getState()->getOwner());
		self::assertEquals(6, $player->getMap()->getRegion(1)->getState()->getArmies());
		
		self::assertEquals(RegionState::OWNER_OPPONENT, $player->getMap()->getRegion(3)->getState()->getOwner());
		self::assertEquals(2, $player->getMap()->getRegion(3)->getState()->getArmies());
		
		self::assertEquals(RegionState::OWNER_NEUTRAL, $player->getMap()->getRegion(4)->getState()->getOwner());
		self::assertEquals(7, $player->getMap()->getRegion(4)->getState()->getArmies());
	}
}