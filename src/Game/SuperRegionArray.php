<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Util\ArrayObject\Filterable;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\GetOffsetable;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;

class SuperRegionArray extends \ArrayObject
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
	 * @return SuperRegion
	 *
	 * @throws RuntimeException
	 */
	public function get($id)
	{
		if( !$this->has($id) )
		{
			throw RuntimeException::UnknownSuperRegion($id);
		}
		return $this->offsetGet($id);
	}

	/**
	 * @param SuperRegion $super_region
	 *
	 * @return $this
	 */
	public function add($super_region)
	{
		$this->offsetSet($super_region->getId(), $super_region);
		return $this;
	}

	/**
	 * @param integer $super_region_id
	 *
	 * @return boolean
	 */
	public function has($super_region_id)
	{
		return $this->offsetExists($super_region_id);
	}
}