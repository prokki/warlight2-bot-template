<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Util\ArrayObject\Filterable;
use Prokki\TheaigamesBotEngine\Util\ArrayObject\GetOffsetable;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;

class SuperRegionArray extends \ArrayObject implements SupraRegional
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
	 * @param SuperRegion|integer $super_region
	 *
	 * @return boolean
	 */
	public function has($super_region)
	{
		$super_region_key = is_integer($super_region) ? $super_region : $super_region->getId();

		return $this->offsetExists($super_region_key);
	}

	/**
	 * @inheritdoc
	 */
	public function hasRegion($region)
	{
		foreach( $this as $_super_region )
		{
			/** @var SuperRegion $_super_region */
			if( $_super_region->has($region) )
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function getRegions()
	{
		$regions = EnvironmentFactory::Get()->newRegionArray();

		foreach( $this as $_super_region )
		{
			/** @var SuperRegion $_super_region */
			foreach( $_super_region->getRegions() as $__region )
			{
				$regions->add($__region);
			}
		}

		return $regions;
	}
}