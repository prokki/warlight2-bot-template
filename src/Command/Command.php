<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

/**
 * Class Command
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class Command
{

	/**
	 * @param Environment $environment
	 */
	abstract public function apply(Environment $environment);

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