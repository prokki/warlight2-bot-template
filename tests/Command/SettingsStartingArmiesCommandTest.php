<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingArmiesCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

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
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsStartingArmiesCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		self::assertEquals(0, $player->getSetting()->getStartingArmies());
		$this->_getTestCommand()->apply($player);
		self::assertEquals(27, $player->getSetting()->getStartingArmies());
	}
}