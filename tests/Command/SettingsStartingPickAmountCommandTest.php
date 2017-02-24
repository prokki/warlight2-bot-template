<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingPickAmountCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Util\CommandParser;

class SettingsStartingPickAmountCommandTest extends CommandTest
{
	/**
	 * @return SettingsStartingPickAmountCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   settings   starting_pick_amount     27    ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsStartingPickAmountCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsStartingPickAmountCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getStartingPickAmount()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setStartingPickAmount()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new Map();

		self::assertEquals(0, $player->getStartingPickAmount());
		$this->_getTestCommand()->apply($player, $map);
		self::assertEquals(27, $player->getStartingPickAmount());
	}
}