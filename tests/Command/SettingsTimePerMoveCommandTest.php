<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsTimePerMoveCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Util\Parser;

class SettingsTimePerMoveCommandTest extends CommandTest
{
	/**
	 * @return SettingsTimePerMoveCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   time_per_move     124654  ');
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
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsTimePerMoveCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsTimePerMoveCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getTimePerMove()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setTimePerMove()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new SetupMap();

		self::assertEquals(0, $player->getTimePerMove());
		$this->_getTestCommand()->apply($player, $map);
		self::assertEquals(124654, $player->getTimePerMove());
	}
}