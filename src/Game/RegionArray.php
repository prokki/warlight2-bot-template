<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Util\ArrayObject\Filterable;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\GetOffsetable;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;

class RegionArray extends \ArrayObject
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
	 * @param integer $id
	 *
	 * @return Region
	 *
	 * @throws RuntimeException
	 */
	public function get($id)
	{
		if( !$this->has($id) )
		{
			throw RuntimeException::UnknownRegion($id);
		}

		return $this->offsetGet($id);
	}

	/**
	 * @param Region $region
	 *
	 * @return $this
	 */
	public function add($region)
	{
		$this->offsetSet($region->getId(), $region);
		return $this;
	}

	/**
	 * @param Region|integer $region
	 *
	 * @return boolean
	 */
	public function has($region)
	{
		$region_key = is_integer($region) ? $region : $region->getId();

		return $this->offsetExists($region_key);
	}

	/**
	 * Returns all regions owned by the specified owner(s).
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
			return ( $_region->getOwner() & $owner ) === $_region->getOwner();
		});
	}
}