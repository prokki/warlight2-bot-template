<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use PHPUnit\Framework\TestCase;

abstract class CommandTest extends TestCase
{

	/**
	 * Tests if the parser returns an object of the appropriate class for the submitted command.
	 */
	abstract public function testParser();

	/**
	 * Tests if the parser applies the command successfully.
	 */
	abstract public function testApply();
}