<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingRegionsCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\CommandParser;

class SettingsStartingRegionsCommandTest extends CommandTest
{
	/**
	 * @return SettingsStartingRegionsCommand
	 */
	protected function _getTestCommand()
	{
		return CommandParser::Init()->run('   settings   starting_regions     1 3    	5 ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntListCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsStartingRegionsCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SettingsStartingRegionsCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntListCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::getStartingRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Setting::setStartingRegions()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEmpty($environment->getPlayer()->getStartingRegions());

		$this->_getTestCommand()->apply($environment);

		self::assertEmpty(array_diff($environment->getPlayer()->getStartingRegions(), [5, 3, 1]));
		self::assertEmpty(array_diff([3, 1, 5], $environment->getPlayer()->getStartingRegions()));
	}
}