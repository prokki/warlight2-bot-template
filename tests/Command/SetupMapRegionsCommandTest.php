<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapRegionsListCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SetupMapRegionsCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SetupMapRegionsListCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   setup_map   regions     1   25	17    3      4    1');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapRegionsListCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArguments()
	{
		Parser::Init()->run('setup_map regions 1 25	17 3 4 1 3   ');
	}

	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();

		self::assertEmpty($player->getMap()->getRegions());
		self::assertFalse($player->getMap()->getRegions()->isLoaded());

		$this->_getTestCommand()->apply($player);

		self::assertTrue($player->getMap()->getRegions()->isLoaded());
		self::assertEquals(3, count($player->getMap()->getRegions()));
		self::assertArrayHasKey(1, $player->getMap()->getRegions());
		self::assertTrue($player->getMap()->getRegions()->offsetExists(17));
		self::assertTrue($player->getMap()->getRegions()->offsetExists(4));
	}
}