<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsYourBotCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\Parser;

class SettingsYourBotCommandTest extends CommandTest
{
	/**
	 * @return SettingsYourBotCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   your_bot     aéß3 bsÜä" \' 	  ßc');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableStringCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsYourBotCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsYourBotCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableStringCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getName()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setName()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEquals('', $environment->getPlayer()->getName());
		$this->_getTestCommand()->apply($environment);
		self::assertEquals('aéß3 bsÜä" \' 	  ßc', $environment->getPlayer()->getName());
	}
}