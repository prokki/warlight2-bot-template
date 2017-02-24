<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\Util\ArrayObject\Filterable;
use Prokki\Warlight2BotTemplate\Util\ArrayObject\LoadedArray;

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