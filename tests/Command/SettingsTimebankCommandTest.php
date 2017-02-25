<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsTimebankCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\CommandParser;

class SettingsTimebankCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SettingsTimebankCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   settings   timebank     124654');
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
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getTimebank()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setTimebank()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEquals(0, $environment->getPlayer()->getTimebank());
		$this->_getTestCommand()->apply($environment);
		self::assertEquals(124654, $environment->getPlayer()->getTimebank());
	}
}