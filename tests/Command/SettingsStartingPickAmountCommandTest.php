<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingPickAmountCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

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
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsStartingPickAmountCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		self::assertEquals(0, $player->getSetting()->getStartingPickAmount());
		$this->_getTestCommand()->apply($player);
		self::assertEquals(27, $player->getSetting()->getStartingPickAmount());
	}
}