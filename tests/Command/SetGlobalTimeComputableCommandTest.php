<?php

namespace Prokki\Warlight2BotTemplate\Test\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

abstract class SetGlobalTimeTest extends CommandTest
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
		$player = new Player();
		$map    = new SetupMap();

		self::assertEquals(0, $player->getGlobalTime());
		$this->_getTestCommand()->apply($player, $map);
		self::assertEquals(9876543, $player->getGlobalTime());
	}
}