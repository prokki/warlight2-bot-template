<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

abstract class SetGlobalTimeComputableCommandTest extends CommandTest
{

	/**
	 * @covers \Prokki\Warlight2BotTemplate\Command\SetGlobalTimeComputableCommand::apply()
	 * @covers \Prokki\Warlight2BotTemplate\Command\ReceivableIntCommand::_parseArguments()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Player::setGlobalTime()
	 * @covers \Prokki\Warlight2BotTemplate\Game\Player::getGlobalTime()
	 *
	 * @inheritdoc
	 */
	public function testApply()
	{
		$environment = new Environment();

		self::assertEquals(0, $environment->getPlayer()->getGlobalTime());
		$this->_getTestCommand()->apply($environment);
		self::assertEquals(9876543, $environment->getPlayer()->getGlobalTime());
	}
}