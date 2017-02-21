<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsOpponentBotCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Util\Parser;

class SettingsOpponentBotCommandTest extends CommandTest
{
	/**
	 * @return SettingsOpponentBotCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   opponent_bot     aéß3 bsÜä" \' 	  ßc');
	}

	/**
	 * @inheritdoc
	 */
	public function testIsApplicable()
	{
		self::assertTrue($this->_getTestCommand()->isApplicable());
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
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		self::assertEquals('', $player->getSetting()->getNameOpponent());
		$this->_getTestCommand()->apply($player);
		self::assertEquals('aéß3 bsÜä" \' 	  ßc', $player->getSetting()->getNameOpponent());
	}
}