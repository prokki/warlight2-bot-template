<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsMaxRoundsCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Util\Parser;

class SettingsMaxRoundsCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SettingsMaxRoundsCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   max_rounds     124654');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsMaxRoundsCommand::class, get_class($this->_getTestCommand()));
	}
	
	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		self::assertEquals(0, $player->getSetting()->getMaxRounds());
		$this->_getTestCommand()->apply($player);
		self::assertEquals(124654, $player->getSetting()->getMaxRounds());
	}
}