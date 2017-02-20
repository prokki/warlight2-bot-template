<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\Exception\RuntimeException;
use Prokki\Warlight2BotTemplate\Util\LoadedArray;

class Map
{

	/**
	 * @var LoadedArray
	 */
	protected $_region = null;

	/**
	 * @var LoadedArraycomposer 
	 */
	protected $_superRegion = null;

	/**
	 * Map constructor.
	 */
	public function __construct()
	{
		$this->_region      = new LoadedArray();
		$this->_superRegion = new LoadedArray();
	}

	/**
	 * Returns `true` if the specified region exists, else `false`.
	 *
	 * @param integer $id id of the region
	 *
	 * @return boolean
	 *
	 */
	public function hasRegion($id)
	{
		return $this->_region->offsetExists($id);
	}

	/**
	 * Returns a region by id.
	 *
	 * If the related region does not exists, an exception is thrown. To avoid exception, use {@see Map::hasRegion()} before.
	 *
	 * @param integer $id
	 *
	 * @return Region
	 *
	 * @throws RuntimeException
	 *
	 */
	public function getRegion($id)
	{
		if( !$this->hasRegion($id) )
		{
			throw RuntimeException::UnknownRegion($id);
		}

		return $this->_region->offsetGet($id);
	}

	/**
	 * Returns all regions.
	 *
	 * @param integer $owner one or multiple owner (see {@see ReggionState} constants) logically combined,
	 *                       example: `getRegions(RegionState::OWNER_ME | RegionState::OWNER_NEUTRAL)`
	 *
	 * @return LoadedArray
	 *
	 */
	public function getRegions($owner = null)
	{

		if( is_null($owner) )
		{
			return $this->_region;
		}

		return $this->_region->filter(function ($_region) use ($owner)
		{
			/** @var Region $_region */
			return $_region->getState()->getOwner() & $owner;
		});
	}

	/**
	 * Returns `true` if the specified super region exists, else `false`.
	 *
	 * @param integer $id id of the super region
	 *
	 * @return boolean
	 *
	 */
	public function hasSuperRegion($id)
	{
		return $this->_superRegion->offsetExists($id);
	}

	/**
	 * Returns a super region by id or `null` if the id does not exsists.
	 *
	 * @param integer $id
	 *
	 * @return SuperRegion
	 *
	 */
	public function getSuperRegion($id)
	{
		return $this->_superRegion->offsetGet($id);
	}

	/**
	 * Returns all super regions.
	 *
	 * @return LoadedArray
	 */
	public function getSuperRegions()
	{
		return $this->_superRegion;
	}
}