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
	 * @var SuperRegionArray
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

		$this->_initializeSetUp(false);

		foreach( $old_regions as $_old_region )
		{
			/** @var Region $_old_region */
			$this->_regions->get($_old_region->getId())->»setState(clone $_old_region->»getState());
		}

		$this->_initialize();
	}

	/**
	 * Override this method in class {@see \Prokki\Warlight2BotTemplate\Game\SetUpMap} to return `true`.
	 *
	 * @param boolean $execute_initialize
	 *
	 * @inheritdoc
	 */
	protected function _initializeSetUp($execute_initialize = true)
	{
		$this->_initializeSuperRegions();

		$this->_initializeRegions();

		$this->_initializeNeighbors();

		$this->_initializeWastelands();

		$this->_initialized = true;

		if( $execute_initialize )
		{
			$this->_initialize();
		}

		return true;
	}

	/**
	 * Initializes all states
	 */
	protected function _initialize()
	{

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
			$this->_superRegions->addSuperRegion(EnvironmentFactory::Get()->newSuperRegion($_super_region_id, $_bonus_armies));
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
			if( !$this->_superRegions->hasSuperRegion($_super_region_id) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			$_super_region = $this->_superRegions->get($_super_region_id);

			foreach( $_region_ids as $__region_id )
			{
				$this->_regions->addRegion(
					EnvironmentFactory::Get()->newRegion($__region_id)->»assignSuperRegion($_super_region)
				);
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
			if( !$this->_regions->hasRegion($_region_id) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			/** @var Region $_region */
			$_region = $this->_regions->get($_region_id);

			foreach( $_neighbor_region_ids as $__neighbor_region_id )
			{
				if( !$this->_regions->hasRegion($__neighbor_region_id) )
				{
					throw InitializationException::MapInitializationFailed();
				}

				$_region->addNeighbor($this->_regions->get($__neighbor_region_id));
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
			if( !$this->_regions->hasRegion($_region_id) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			$this->_regions->get($_region_id)->setWasteland();
		}
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
			$_region = $this->_regions->get($_region_id);

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