<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsOpponentBotCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Util\Parser;

class SettingsOpponentBotCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SettingsOpponentBotCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   opponent_bot     aéß3 bsÜä" \' 	  ßc');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsOpponentBotCommand::class, get_class($this->_getTestCommand()));
	}

	/**
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