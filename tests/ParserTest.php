<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prokki\Warlight2BotTemplate\Test;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Util\Parser;

class ParserTest extends TestCase
{

	/**
	 * @expectedException \Prokki\Warlight2BotTemplate\Exception\ParserException
	 * @expectedExceptionCode 102
	 */
	public function testUnknownCommand()
	{
		$player = Parser::Init();
		$player->run("Lorem ipsum dolor sit amet [...]");
	}
}