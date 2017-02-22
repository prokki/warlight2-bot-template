<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand;
use Prokki\Warlight2BotTemplate\Command\ReceivableCommand;
use Prokki\Warlight2BotTemplate\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\Player;

class StaticCommandTest extends TestCase
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
		$player_me       = rand_string(rand(4, 40));
		$player_opponent = rand_string(rand(4, 40));

		$player = new Player();

		$player->setName($player_me);
		$player->setNameOpponent($player_opponent);

		$reflection_method = new \ReflectionMethod(ReceivableCommand::class, '_GetRegionOwnerByPlayerName');
		$reflection_method->setAccessible(true);

		$some_command_object = new PickStartingRegionCommand('setup_map', '3 4');

		self::assertEquals(RegionState::OWNER_NEUTRAL, $reflection_method->invokeArgs($some_command_object, array($player, 'neutral')));
		self::assertEquals(RegionState::OWNER_ME, $reflection_method->invokeArgs($some_command_object, array($player, $player_me)));
		self::assertEquals(RegionState::OWNER_OPPONENT, $reflection_method->invokeArgs($some_command_object, array($player, $player_opponent)));
	}

	/**
	 *
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableCommand::_GetRegionOwnerByPlayerName()
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 105
	 *
	 */
	public function testGetRegionOwnerByPlayerNameWithException()
	{
		$player = new Player();

		$some_command_object = new PickStartingRegionCommand('setup_map', '3 4');

		$reflection_method = new \ReflectionMethod($some_command_object, '_GetRegionOwnerByPlayerName');
		$reflection_method->setAccessible(true);

		$reflection_method->invokeArgs($some_command_object, array($player, rand_string(rand(4, 40))));
	}
}