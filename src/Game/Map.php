<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\Exception\InitializationException;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;
use Prokki\Warlight2BotTemplate\Game\Move\PickMove;

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

		$this->_regions      = EnvironmentFactory::Get()->newRegionArray();
		$this->_superRegions = EnvironmentFactory::Get()->newSuperRegionArray();
	}

	/**
	 * Map constructor.
	 */
	public function __clone()
	{
		$old_regions = $this->_regions;

		$this->_regions      = EnvironmentFactory::Get()->newRegionArray();
		$this->_superRegions = EnvironmentFactory::Get()->newSuperRegionArray();

		$this->initialize();

		foreach( $old_regions as $_old_region )
		{
			/** @var Region $_old_region */
			$this->getRegion($_old_region->getId())->»setState(clone $_old_region->»getState());
		}
	}

	/**
	 * Returns `true` if the map is initialized successfully, else `false`.
	 */
	public function initialize()
	{
		$this->_initializeSuperRegions();

		$this->_initializeRegions();

		$this->_initializeNeighbors();

		$this->_initializeWastelands();

		$this->_initialized = true;

		return true;
	}

	/**
	 * Initializes the {@see \Prokki\Warlight2BotTemplate\Game\Map::_superRegions} property.
	 *
	 * Take care that the array {@see \Prokki\Warlight2BotTemplate\Game\SetupMap::_superRegionIds} was filled before.
	 */
	protected function _initializeSuperRegions()
	{
		foreach( $this->_superRegionIds as $_super_region_id => $_bonus_armies )
		{
			$this->_superRegions->offsetSet($_super_region_id, EnvironmentFactory::Get()->newSuperRegion($_super_region_id, $_bonus_armies));
		}
	}

	/**
	 * Initializes the {@see \Prokki\Warlight2BotTemplate\Game\Map::_regions} property.
	 *
	 * Take care that
	 * 1. the array {@see \Prokki\Warlight2BotTemplate\Game\SetupMap::_regionIds} was filled before.
	 * 2. the super regions was initialized, see {@see \Prokki\Warlight2BotTemplate\Game\Map::_initializeSuperRegions()}.
	 *
	 * @throws InitializationException
	 */
	protected function _initializeRegions()
	{
		foreach( $this->_regionIds as $_super_region_id => $_region_ids )
		{
			if( !$this->hasSuperRegion($_super_region_id) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			$_super_region = $this->getSuperRegion($_super_region_id);

			foreach( $_region_ids as $__region_id )
			{
				$__region = EnvironmentFactory::Get()->newRegion($__region_id)->»assignSuperRegion($_super_region);

				$this->_regions->offsetSet($__region_id, $__region);
			}
		}
	}

	/**
	 * Initializes the {@see \Prokki\Warlight2BotTemplate\Game\Map::_regions} property.
	 *
	 * Take care the regions were initialized by {@see \Prokki\Warlight2BotTemplate\Game\Map::_initializeRegions()}.
	 *
	 * @throws InitializationException
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
	 * @return RegionArray
	 *
	 */
	public function getRegions()
	{
		return $this->_regions;
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
			throw RuntimeException::UnknownSuperRegion($id);
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


	/**
	 * Checks all submitted regions if they were already picked by a player,
	 * sets the owner to the opponent for the regions which are not picked yet and
	 * returns {@see PickMove}s for these regions.
	 *
	 * @param integer $region_ids ids of the regions to check
	 *
	 * @return PickMove[] pick moves for all unpicked regions
	 *
	 */
	public function getUniqueOpponentPickMoves($region_ids)
	{
		$moves = array();

		foreach( $region_ids as $_region_id )
		{
			$_region = $this->getRegion($_region_id);

			// region cannot be picked twice (region was picked already)
			if( in_array($_region->getOwner(), [RegionState::OWNER_ME, RegionState::OWNER_OPPONENT]) )
			{
				continue;
			}

			$_region->»getState()->setOwner(RegionState::OWNER_OPPONENT);

			array_push($moves, new PickMove($_region_id));
		}

		return $moves;
	}
}