<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsTimebankCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SettingsTimebankCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SettingsTimebankCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   timebank     124654');
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
		self::assertEquals(SettingsTimebankCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsTimebankCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		self::assertEquals(0, $player->getSetting()->getTimebank());
		$this->_getTestCommand()->apply($player);
		self::assertEquals(124654, $player->getSetting()->getTimebank());
	}
}