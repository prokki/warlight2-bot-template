<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\GoAttackTransferCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\GamePlay\AI;
use Prokki\Warlight2BotTemplate\Game\Move\AttackMove;
use Prokki\Warlight2BotTemplate\Game\Move\TransferMove;
use Prokki\Warlight2BotTemplate\Command\Parser;

class GoAttackTransferCommandTest extends SetGlobalTimeComputableCommandTest
{
	/**
	 * @return GoAttackTransferCommand
	 */
	protected function _getTestCommand()
	{
		return Parser::Init()->run('   go	attack/transfer 		 9876543  	 	 ');
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		self::assertEquals(GoAttackTransferCommand::class, get_class($this->_getTestCommand()));
	}

	/**
	 * @covers                \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 *
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\CommandException
	 * @expectedExceptionCode 104
	 */
	public function testParserMissingArguments()
	{
		Parser::Init()->run('go attack/transfer');
	}

	/**
	 * @inheritdoc
	 */
	public function testIsComputable()
	{
		self::assertTrue($this->_getTestCommand()->isComputable());
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\GoAttackTransferCommand::compute()
	 */
	public function testComputeNoMoves()
	{
		$environment = new Environment();
		$ai = $this->createMock(AI::class);

		$ai->method('getAttackTransferMoves')->willReturn(array());
		$this->assertEquals('No moves', $this->_getTestCommand()->compute($ai, $environment));
	}

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\GoAttackTransferCommand::compute()
	 */
	public function testCompute()
	{
		$environment = new Environment();
		$ai = $this->createMock(AI::class);

		$ai->method('getAttackTransferMoves')->willReturn([
			new TransferMove(1, 2, 17),
			new AttackMove(3, 4, 6),
			new TransferMove(5, 9, 2),
			new AttackMove(3, 4, 6),
			new AttackMove(3, 4, 6),
		]);

		$method_result = $this->_getTestCommand()->compute($ai, $environment);

		// five moves
		$this->assertEquals(5, count(explode(',', $method_result)));
	}
}