<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Util\ArrayObject\Filterable;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\GetOffsetable;

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
	 * @return SuperRegion|null
	 */
	public function get($id)
	{
		if( !$this->hasSuperRegion($id) )
		{
			return null;
		}
		return $this->offsetGet($id);
	}

	/**
	 * @param SuperRegion $super_region
	 *
	 * @return $this
	 */
	public function addSuperRegion($super_region)
	{
		$this->offsetSet($super_region->getId(), $super_region);
		return $this;
	}

	/**
	 * @param integer $super_region_id
	 *
	 * @return boolean
	 */
	public function hasSuperRegion($super_region_id)
	{
		return $this->offsetExists($super_region_id);
	}
}