<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\EmptyReceivableCommand;
use Prokki\Warlight2BotTemplate\Game\Environment;

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
		// test not possible because the EmptyReceivableCommand is for testing or not implemented requests
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		self::assertEmpty($this->_getTestCommand()->apply(new Environment()));
	}
}