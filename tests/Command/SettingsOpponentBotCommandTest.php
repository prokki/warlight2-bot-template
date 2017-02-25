<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsOpponentBotCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\CommandParser;

class SettingsOpponentBotCommandTest extends CommandTest
{
	/**
	 * @return SettingsOpponentBotCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   settings   opponent_bot     aéß3 bsÜä" \' 	  ßc');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableStringCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsOpponentBotCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsOpponentBotCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableStringCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setNameOpponent()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getNameOpponent()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEquals('', $environment->getPlayer()->getNameOpponent());
		$this->_getTestCommand()->apply($environment);
		self::assertEquals('aéß3 bsÜä" \' 	  ßc', $environment->getPlayer()->getNameOpponent());
	}
}