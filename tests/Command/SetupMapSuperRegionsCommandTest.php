<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapSuperRegionsCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\Util\Parser;

class SetupMapSuperRegionsCommandTest extends CommandTest
{
	/**
	 * @return SetupMapSuperRegionsCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   setup_map   super_regions     1   25	17    3      4    1');
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
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableTupleIntListCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(SetupMapSuperRegionsCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\ReceivableTupleIntListCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArguments()
	{
		Parser::Init()->run('setup_map super_regions 1 25	17 3 4 1 3   ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetupMapSuperRegionsCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableTupleIntListCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::getSuperRegions()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::hasSuperRegion()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addSuperRegion()
	 * @covers \Prokki\Warlight2BotTemplate\Util\LoadedArray::isLoaded()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegion::getBonusArmies()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$player = new Player();
		$map    = new SetupMap();

		self::assertEmpty($map->getSuperRegions());
		self::assertFalse($map->getSuperRegions()->isLoaded());

		$this->_getTestCommand()->apply($player, $map);

		self::assertTrue($map->getSuperRegions()->isLoaded());
		self::assertEquals(3, count($map->getSuperRegions()));
		self::assertArrayHasKey(1, $map->getSuperRegions());
		self::assertTrue($map->hasSuperRegion(17));
		self::assertTrue($map->hasSuperRegion(4));
		self::assertInternalType('integer', $map->getSuperRegions()->offsetGet(17)->getBonusArmies());
		self::assertEquals(3, $map->getSuperRegions()->offsetGet(17)->getBonusArmies());
	}
}