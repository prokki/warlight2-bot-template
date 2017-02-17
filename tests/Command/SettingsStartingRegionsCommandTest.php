<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SettingsStartingRegionsListCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SettingsStartingRegionsCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SettingsStartingRegionsListCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   settings   starting_regions     1 3    	5 ');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SettingsStartingRegionsListCommand::class, get_class($this->_getTestCommand()));
	}

	/**
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