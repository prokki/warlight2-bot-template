<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsMaxRoundsCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\Parser;

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
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getMaxRounds()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setMaxRounds()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();
		
		self::assertEquals(0, $environment->getPlayer()->getMaxRounds());
		$this->_getTestCommand()->apply($environment);
		self::assertEquals(124654, $environment->getPlayer()->getMaxRounds());
	}
}