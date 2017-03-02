<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingArmiesCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\Parser;

class SettingsStartingArmiesCommandTest extends CommandTest
{
	/**
	 * @return SettingsStartingArmiesCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   starting_armies     27    ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsStartingArmiesCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsStartingArmiesCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getStartingArmies()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setStartingArmies()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEquals(0, $environment->getPlayer()->getStartingArmies());
		$this->_getTestCommand()->apply($environment);
		self::assertEquals(27, $environment->getPlayer()->getStartingArmies());
	}
}