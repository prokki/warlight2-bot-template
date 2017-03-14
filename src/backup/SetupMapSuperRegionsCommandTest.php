<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\SetupMapSuperRegionsCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Command\Parser;

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
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\CommandException
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
	 * @covers \Prokki\Warlight2BotTemplate\Game\Map::has()
	 * @covers \Prokki\Warlight2BotTemplate\Game\RegionArray::isLoaded()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SetupMap::addSuperRegionSetUp()
	 * @covers \Prokki\Warlight2BotTemplate\Game\SuperRegion::getBonusArmies()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEmpty($environment->getMap()->getSuperRegions());
		self::assertFalse($environment->getMap()->getSuperRegions()->isLoaded());

		$this->_getTestCommand()->apply($environment);

		self::assertTrue($environment->getMap()->getSuperRegions()->isLoaded());
		self::assertEquals(3, count($environment->getMap()->getSuperRegions()));
		self::assertArrayHasKey(1, $environment->getMap()->getSuperRegions());
		self::assertTrue($environment->getMap()->getSuperRegions()->has(17));
		self::assertTrue($environment->getMap()->getSuperRegions()->has(4));
		self::assertInternalType('integer', $environment->getMap()->getSuperRegions()->offsetGet(17)->getBonusArmies());
		self::assertEquals(3, $environment->getMap()->getSuperRegions()->offsetGet(17)->getBonusArmies());
	}
}