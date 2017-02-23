<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;

/**
 * Class Command
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class Command
{

	/**
	 * @param Player $player
	 * @param Map    $map
	 *
	 * @return
	 */
	abstract public function apply(Player $player, Map $map);

	/**
	 * Returns `true` if the command is computable (has method `compute()`, see interface {@see Computable), else `false`.
	 *
	 * @return boolean
	 */
	public function isComputable()
	{
		return in_array(Computable::class, class_implements($this));
	}

}