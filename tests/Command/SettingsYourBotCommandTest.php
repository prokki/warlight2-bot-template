<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsYourBotCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SettingsYourBotCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SettingsYourBotCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   your_bot     aéß3 bsÜä" \' 	  ßc');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsYourBotCommand::class, get_class($this->_getTestCommand()));
	}
	
	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		self::assertEquals('', $player->getSetting()->getName());
		$this->_getTestCommand()->apply($player);
		self::assertEquals('aéß3 bsÜä" \' 	  ßc', $player->getSetting()->getName());
	}
}