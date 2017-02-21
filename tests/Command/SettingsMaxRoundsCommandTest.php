<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsMaxRoundsCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Util\Parser;

class SettingsMaxRoundsCommandTest extends CommandTest
{
	/**
	 * @return SettingsMaxRoundsCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   max_rounds     124654');
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
		self::assertEquals(SettingsMaxRoundsCommand::class, get_class($this->_getTestCommand()));
	}
	
	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsMaxRoundsCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 * 
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