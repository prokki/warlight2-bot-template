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
	public function testIsApplicable()
	{
		self::assertTrue($this->_getTestCommand()->isApplicable());
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
	 * 
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