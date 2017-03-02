<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand;
use Prokki\Warlight2BotTemplate\Command\UpdateMapCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\SuperRegion;
use Prokki\Warlight2BotTemplate\Command\Parser;

class UpdateMapCommandTest extends CommandTest
{
	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableCommand::_GetRegionOwnerByPlayerName()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getName()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setName()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setNameOpponent()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getNameOpponent()
	 */
	public function testGetRegionOwnerByPlayerName()
	{
		$player_me = rand_string(rand(4, 40));
		$player_opponent = rand_string(rand(4, 40));

		$environment = new Environment();

		$environment->getPlayer()->setName($player_me);
		$environment->getPlayer()->setNameOpponent($player_opponent);

		$reflection_method = new \ReflectionMethod(UpdateMapCommand::class, '_GetRegionOwnerByPlayerName');
		$reflection_method->setAccessible(true);

		$some_command_object = new PickStartingRegionCommand('setup_map', '3 4');

		self::assertEquals(RegionState::OWNER_NEUTRAL, $reflection_method->invokeArgs($some_command_object, array('neutral', $environment->getPlayer())));
		self::assertEquals(RegionState::OWNER_ME, $reflection_method->invokeArgs($some_command_object, array($player_me, $environment->getPlayer())));
		self::assertEquals(RegionState::OWNER_OPPONENT, $reflection_method->invokeArgs($some_command_object, array($player_opponent, $environment->getPlayer())));
	}

	/**
	 *
	 * @covers \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::_GetRegionOwnerByPlayerName()
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 105
	 *
	 */
	public function testGetRegionOwnerByPlayerNameWithException()
	{
		$environment = new Environment();

		$some_command_object = new UpdateMapCommand('update_map', '1 player1 6');

		$reflection_method = new \ReflectionMethod($some_command_object, '_GetRegionOwnerByPlayerName');
		$reflection_method->setAccessible(true);

		$reflection_method->invokeArgs($some_command_object, array(rand_string(rand(4, 40)), $environment->getPlayer()));
	}

	/**
	 * @return UpdateMapCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   update_map 1 player1 6 3 player2 2		4      neutral    7   	   ');
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
		Parser::Init()->run('update_map 1 player1');
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingOneArgument()
	{
		Parser::Init()->run('update_map 1 player1');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\UpdateMapCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		$super_region = new SuperRegion(1, 7);

		$environment->getPlayer()
			->setName('player1')
			->setNameOpponent('player2');

		$regions = $environment->getMap()->getRegions();

		for ($_i = 1; $_i <= 20; $_i++) {
			$regions->offsetSet($_i, new Region($_i, $super_region));
		}

		$this->_getTestCommand()->apply($environment);

		self::assertEquals(RegionState::OWNER_ME, $environment->getMap()->getRegion(1)->getOwner());
		self::assertEquals(6, $environment->getMap()->getRegion(1)->getArmies());

		self::assertEquals(RegionState::OWNER_OPPONENT, $environment->getMap()->getRegion(3)->getOwner());
		self::assertEquals(2, $environment->getMap()->getRegion(3)->getArmies());

		self::assertEquals(RegionState::OWNER_NEUTRAL, $environment->getMap()->getRegion(4)->getOwner());
		self::assertEquals(7, $environment->getMap()->getRegion(4)->getArmies());
	}
}