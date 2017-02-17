<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapSuperRegionsListCommand;
use Prokki\Warlight2BotTemplate\Util\Parser;
use Prokki\Warlight2BotTemplate\Game\Player;

class SetupMapSuperRegionsCommandTest extends CommandTest
{
	/**
	 * @return \Prokki\Warlight2BotTemplate\Command\SetupMapSuperRegionsListCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   setup_map   super_regions     1   25	17    3      4    1');
	}

	/**
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapSuperRegionsListCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArguments()
	{
		Parser::Init()->run('setup_map super_regions 1 25	17 3 4 1 3   ');
	}

	/**
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();

		self::assertEmpty($player->getMap()->getSuperRegions());
		self::assertFalse($player->getMap()->getSuperRegions()->isLoaded());

		$this->_getTestCommand()->apply($player);

		self::assertTrue($player->getMap()->getSuperRegions()->isLoaded());
		self::assertEquals(3, count($player->getMap()->getSuperRegions()));
		self::assertArrayHasKey(1, $player->getMap()->getSuperRegions());
		self::assertTrue($player->getMap()->hasSuperRegion(17));
		self::assertTrue($player->getMap()->hasSuperRegion(4));
		self::assertInternalType('integer', $player->getMap()->getSuperRegions()->offsetGet(17)->getBonusArmies());
		self::assertEquals(3, $player->getMap()->getSuperRegions()->offsetGet(17)->getBonusArmies());
	}
}