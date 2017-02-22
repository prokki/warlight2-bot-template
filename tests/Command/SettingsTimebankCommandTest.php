<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsTimebankCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Util\Parser;

class SettingsTimebankCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SettingsTimebankCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   timebank     124654');
	}

	/**
	 *
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
		self::assertEquals(SettingsTimebankCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsTimebankCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getTimebank()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setTimebank()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new SetupMap();

		self::assertEquals(0, $player->getTimebank());
		$this->_getTestCommand()->apply($player, $map);
		self::assertEquals(124654, $player->getTimebank());
	}
}