<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\GoPlaceArmiesCommand;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\GamePlay\AIable;
use Prokki\Warlight2BotTemplate\GamePlay\PlaceMove;
use Prokki\Warlight2BotTemplate\Util\Parser;

class GoPlaceArmiesCommandTest extends SetGlobalTimeComputableCommandTest
{
	/**
	 * @return GoPlaceArmiesCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   go	place_armies 		 9876543  	 	 ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(GoPlaceArmiesCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArguments()
	{
		Parser::Init()->run('go place_armies');
	}

	/**
	 * @inheritdoc
	 */
	public function testIsComputable()
	{
		self::assertTrue($this->_getTestCommand()->isComputable());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\GoPlaceArmiesCommand::_moveToString()
	 */
	public function testMoveToString()
	{
		$player = new Player();
		$player->setName("ßäöü");

		$move = new PlaceMove(7, -999);

		$reflection_method = new \ReflectionMethod(GoPlaceArmiesCommand::class, '_moveToString');
		$reflection_method->setAccessible(true);

		self::assertEquals('ßäöü place_armies 7 -999', $reflection_method->invokeArgs($this->_getTestCommand(), array($player, $move)));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\GoPlaceArmiesCommand::compute()
	 */
	public function testComputeNoMoves()
	{
		$player = new Player();
		$map    = new Map();
		$ai     = $this->createMock(AIable::class);

		$ai->method('getPlaceMoves')->willReturn(array());
		$this->assertEquals('No moves', $this->_getTestCommand()->compute($ai, $player, $map));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\GoPlaceArmiesCommand::compute()
	 */
	public function testCompute()
	{
		$player = new Player();
		$map    = new Map();
		$ai     = $this->createMock(AIable::class);

		$ai->method('getPlaceMoves')->willReturn([
			new PlaceMove(1, 2, 17),
			new PlaceMove(3, 4, 6),
			new PlaceMove(5, 9, 2),
		]);

		// call method
		$method_result = $this->_getTestCommand()->compute($ai, $player, $map);

		// three moves
		$this->assertEquals(3, count(explode(',', $method_result)));
	}
}