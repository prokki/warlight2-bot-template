<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingPickAmountCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\Parser;

class SettingsStartingPickAmountCommandTest extends CommandTest
{
	/**
	 * @return SettingsStartingPickAmountCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   starting_pick_amount     27    ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsStartingPickAmountCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsStartingPickAmountCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getStartingPickAmount()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setStartingPickAmount()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEquals(0, $environment->getPlayer()->getStartingPickAmount());
		$this->_getTestCommand()->apply($environment);
		self::assertEquals(27, $environment->getPlayer()->getStartingPickAmount());
	}
}