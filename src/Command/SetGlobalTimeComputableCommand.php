<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

/**
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class SetGlobalTimeComputableCommand extends ReceivableIntCommand implements Computable
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, Map $map)
	{
		$player->setGlobalTime($this->_value);
	}

}