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
		$offsets = array();

		foreach( $this as $_offset => $_ )
		{
			array_push($offsets, $_offset);
		}

		return $offsets;
	}
}