<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapWastelandsListCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SetupMapWastelandsCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SetupMapWastelandsListCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   setup_map   wastelands     1 3    	5 ');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapWastelandsListCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();

		/** @var \Warlight2BotTemplate\Map\SetupMap $map */
		$map = $player->getMap();
		self::assertEmpty($map->getWastelands());
		self::assertFalse($map->getWastelands()->isLoaded());

		$this->_getTestCommand()->apply($player);

		self::assertTrue($map->getWastelands()->isLoaded());
		self::assertEquals(3, count($map->getWastelands()));

		self::assertEmpty(array_diff($map->getWastelands()->getArrayCopy(), [5, 3, 1]));
		self::assertEmpty(array_diff([3, 1, 5], $map->getWastelands()->getArrayCopy()));
	}
}