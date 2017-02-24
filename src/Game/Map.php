<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\Exception\RuntimeException;

class Map extends SetupMap
{

	/**
	 * @var RegionArray
	 */
	protected $_regions = null;

	/**
	 * @var RegionArray
	 */
	protected $_superRegions = null;

	/**
	 * Map constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->_regions      = new RegionArray();
		$this->_superRegions = new RegionArray();
	}

	/**
	 * Map constructor.
	 */
	public function __clone()
	{
		$old_regions = $this->_regions;

		$this->_regions      = new RegionArray();
		$this->_superRegions = new RegionArray();

		$this->_initialize();

		foreach( $old_regions as $_old_region )
		{
			/** @var Region $_old_region */
			$this->getRegion($_old_region->getId())->setState(clone $_old_region->getState());
		}
	}

	/**
	 * Returns `true` if the map is initialized successfully, else `false`.
	 *
	 * @throws InitializationException
	 *
	 * @todo test method!
	 */
	public function initialize()
	{
		$this->_initializeSuperRegions();

		$this->_initializeRegions();

		$this->_initializeNeighbors();

		$this->_initializeWastelands();

		$this->_initialized = true;
	}

	/**
	 * Returns `true` if the map is initialized successfully, else `false`.
	 *
	 * @throws InitializationException
	 *
	 * @todo test method!
	 */
	protected function _initializeSuperRegions()
	{
		foreach( $this->_superRegionIds as $_super_region_id => $_bonus_armies )
		{
			/** @var SuperRegion $_super_region */
			if( $this->hasSuperRegion($_super_region_id) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			$this->_superRegions->offsetSet($_super_region_id, new SuperRegion($_super_region_id, $_bonus_armies));
		}
	}

	/**
	 * Returns `true` if the map is initialized successfully, else `false`.
	 *
	 * @throws InitializationException
	 *
	 * @todo test method!
	 */
	protected function _initializeRegions()
	{
		foreach( $this->_regionIds as $_super_region_id => $_region_ids )
		{
			/** @var SuperRegion $_super_region */
			if( !$this->hasSuperRegion($_super_region_id) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			$_super_region = $this->getSuperRegion($_super_region_id);

			foreach( $_region_ids as $__region_id )
			{
				$this->_regions->offsetSet($__region_id, new Region($__region_id, $_super_region));
			}
		}

		// @todo test if all regions are converted?
		$uninitialized_regions = $this->_regions->filter(function ($_region)
		{
			/** @var Region $_region */
			return !$_region->hasSuperRegion();
		});

		if( count($uninitialized_regions) > 0 )
		{
			throw InitializationException::MapInitializationFailed();
		}
	}

	/**
	 * Returns `true` if the map is initialized successfully, else `false`.
	 *
	 * @throws InitializationException
	 *
	 * @todo test method!
	 */
	protected function _initializeNeighbors()
	{
		// 2. initialize neighbors
		foreach( $this->_neighborRegionIds as $_region_id => $_neighbor_region_ids )
		{
			if( !$this->hasRegion($_region_id) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			/** @var Region $_region */
			$_region = $this->getRegion($_region_id);

			foreach( $_neighbor_region_ids as $__neighbor_region_id )
			{
				if( !$this->hasRegion($__neighbor_region_id) )
				{
					throw InitializationException::MapInitializationFailed();
				}

				$_region->addNeighbor($this->getRegion($__neighbor_region_id));
			}
		}
	}

	/**
	 * Returns `true` if the map is initialized successfully, else `false`.
	 *
	 * @throws InitializationException
	 *
	 * @todo test method!
	 */
	protected function _initializeWastelands()
	{
		// 2. initialize neighbors
		foreach( $this->_wastelandIds as $_region_id )
		{
			if( !$this->hasRegion($_region_id) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			$this->getRegion($_region_id)->setWasteland();
		}
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
		return $this->_regions->offsetExists($id);
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

		return $this->_regions->offsetGet($id);
	}

	/**
	 * Returns all regions.
	 *
	 * @param integer $owner one or multiple owner (see {@see ReggionState} constants) logically combined,
	 *                       example: `getRegions(RegionState::OWNER_ME | RegionState::OWNER_NEUTRAL)`
	 *
	 * @return RegionArray
	 *
	 */
	public function getRegions($owner = null)
	{

		if( is_null($owner) )
		{
			return $this->_regions;
		}

		return $this->_regions->filter(function ($_region) use ($owner)
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
		return $this->_superRegions->offsetExists($id);
	}

	/**
	 * Returns a super region by id or `null` if the id does not exsists.
	 *
	 * @param integer $id
	 *
	 * @return SuperRegion
	 *
	 * @throws RuntimeException
	 */
	public function getSuperRegion($id)
	{
		if( !$this->hasSuperRegion($id) )
		{
			throw RuntimeException::UnknownRegion($id);
		}

		return $this->_superRegions->offsetGet($id);
	}

	/**
	 * Returns all super regions.
	 *
	 * @return RegionArray
	 */
	public function getSuperRegions()
	{
		return $this->_superRegions;
	}
}