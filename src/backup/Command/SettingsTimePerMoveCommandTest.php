<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsTimePerMoveCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\Parser;

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
		$environment = new Environment();

		self::assertEquals(0, $environment->getPlayer()->getTimePerMove());
		$this->_getTestCommand()->apply($environment);
		self::assertEquals(124654, $environment->getPlayer()->getTimePerMove());
	}
}