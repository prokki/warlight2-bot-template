<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsYourBotCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Util\CommandParser;

class SettingsYourBotCommandTest extends CommandTest
{
	/**
	 * @return SettingsYourBotCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   settings   your_bot     aéß3 bsÜä" \' 	  ßc');
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
		$player = new Player();
		$map    = new Map();

		self::assertEquals('', $player->getName());
		$this->_getTestCommand()->apply($player, $map);
		self::assertEquals('aéß3 bsÜä" \' 	  ßc', $player->getName());
	}
}