<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingRegionsCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SettingsStartingRegionsCommandTest extends CommandTest
{
	/**
	 * @return SettingsStartingRegionsCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   starting_regions     1 3    	5 ');
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
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player  = new Player();
		$setting = $player->getSetting();
		self::assertEmpty($setting->getStartingRegions());

		$this->_getTestCommand()->apply($player);

		self::assertEmpty(array_diff($setting->getStartingRegions(), [5, 3, 1]));
		self::assertEmpty(array_diff([3, 1, 5], $setting->getStartingRegions()));
	}
}