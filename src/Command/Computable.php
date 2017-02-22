<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\GamePlay\AIable;

interface Computable
{
	/**
	 * @param AIable $ai
	 * @param Player $player
	 * @param Map    $map
	 *
	 * @return String
	 */
	public function compute($ai, Player $player, Map $map);
}