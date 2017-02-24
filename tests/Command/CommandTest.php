<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Command\Command;

abstract class CommandTest extends TestCase
{
	/**
	 * @return Command
	 */
	abstract protected function _getTestCommand();

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Util\CommandParser::run()
	 */
	abstract public function testParser();

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\Command::isComputable()
	 */
	public function testIsComputable()
	{
		self::assertFalse($this->_getTestCommand()->isComputable());
	}
}