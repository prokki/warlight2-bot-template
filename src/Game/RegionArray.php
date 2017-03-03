<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Util\ArrayObject\Filterable;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\LoadedArray;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\GetOffsetable;

class RegionArray extends LoadedArray
{
	use Filterable, GetOffsetable;

	/**
	 * @return integer[]
	 */
	public function getIds()
	{
		return $this->getOffsets();
	}

	/**
	 * Returns alle regions owned by the specified owner(s).
	 *
	 * @param integer $owner one or multiple owner (see {@see RegionState} constants) logically combined,
	 *                       example: `getRegions(RegionState::OWNER_ME | RegionState::OWNER_NEUTRAL)`
	 *
	 * @return RegionArray
	 *
	 */
	public function filterOwner($owner)
	{
		return $this->filter(function ($_region) use ($owner)
		{
			/** @var Region $_region */
			return $_region->getOwner() & $owner;
		});
	}
}