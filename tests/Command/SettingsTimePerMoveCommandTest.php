<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsTimePerMoveCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SettingsTimePerMoveCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SettingsTimePerMoveCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   time_per_move     124654  ');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsTimePerMoveCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		self::assertEquals(0, $player->getSetting()->getTimePerMove());
		$this->_getTestCommand()->apply($player);
		self::assertEquals(124654, $player->getSetting()->getTimePerMove());
	}
}