<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Util\ArrayObject\Filterable;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\LoadedArray;

class RegionArray extends LoadedArray
{
	use Filterable;

	/**
	 * @return integer[]
	 */
	public function getOffsets()
	{
		return array_keys($this->getArrayCopy());
	}
}