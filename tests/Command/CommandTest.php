<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use PHPUnit\Framework\TestCase;

abstract class CommandTest extends TestCase
{

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Util\Parser::run()
	 */
	abstract public function testParser();

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\Command::isApplicable()
	 */
	abstract public function testIsApplicable();
}