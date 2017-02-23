<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\EmptyReceivableCommand;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

class EmptyReceivableCommandTest extends CommandTest
{
	/**
	 * @return EmptyReceivableCommand
	 */
	protected function _getTestCommand()
	{
		return new EmptyReceivableCommand();
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		$this->markTestSkipped('Parser can not return an EmptyReceivableCommand at any time.');
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		self::assertEmpty($this->_getTestCommand()->apply(new Player(), new Map()));
	}
}