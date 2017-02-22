<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

/**
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class SetGlobalTimeComputableCommand extends ReceivableIntCommand implements Computable
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, SetupMap $map)
	{
		$player->setGlobalTime($this->_value);
	}

}