<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Command\EmptyReceiveCommand;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

class EmptyReceiveCommandTest extends CommandTest
{
	/**
	 * @return EmptyReceiveCommand
	 */
	protected function _getTestCommand()
	{
		return new EmptyReceiveCommand();
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function testParser()
	{
		$this->markTestSkipped('Parser can not return an EmptyReceiveCommand at any time.');
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		self::assertEmpty($this->_getTestCommand()->apply(new Player(), new SetupMap()));
	}
}