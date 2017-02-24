<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\GamePlay\AIable;

interface Computable
{
	/**
	 * @param AIable      $ai
	 * @param Environment $environment
	 *
	 * @return String
	 */
	public function compute($ai, Environment $environment);
}