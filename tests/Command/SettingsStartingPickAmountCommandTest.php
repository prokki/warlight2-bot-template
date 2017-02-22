<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingPickAmountCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Util\Parser;

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
		$map    = new SetupMap();

		self::assertEquals(0, $player->getStartingPickAmount());
		$this->_getTestCommand()->apply($player, $map);
		self::assertEquals(27, $player->getStartingPickAmount());
	}
}