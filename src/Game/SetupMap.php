<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\Exception\InitializationException;
use Prokki\Warlight2BotTemplate\Util\Initializeable;
use Prokki\Warlight2BotTemplate\Util\LoadedArray;

class SetupMap extends Map
{

	use Initializeable;

	/**
	 * @var integer[]
	 */
	protected $_preInitSuperRegionMapping = array();

	/**
	 * @var LoadedArray
	 */
	protected $_preInitNeighbors = null;

	/**
	 * @var LoadedArray
	 */
	protected $_preInitWastelands = null;

	/**
	 * Map constructor.
	 */
	public function __construct()
	{
		$this->_preInitNeighbors  = new LoadedArray();
		$this->_preInitWastelands = new LoadedArray();

		parent::__construct();
	}

	/**
	 * Rerturs `true` if the map is initialized successfully, else `false`.
	 *
	 * @return boolean
	 */
	public function canBeInitialized()
	{
		return
			$this->_region->isLoaded()
			&& $this->_superRegion->isLoaded()
			&& $this->_preInitNeighbors->isLoaded()
			&& $this->_preInitWastelands->isLoaded();
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
		foreach( $this->_preInitSuperRegionMapping as $_region_id => $_super_region_id )
		{
			/** @var Region $_region */
			$_region = $this->_region->offsetGet($_region_id);

			/** @var SuperRegion $_super_region */
			$_super_region = $this->_superRegion->offsetGet($_super_region_id);

			if( $_region->hasSuperRegion() )
			{
				continue;
			}

			$_region->setSuperRegion($_super_region);
		}

		// @todo test if all regions are converted?
		$uninitialized_regions = $this->_region->filter(function ($_region)
		{
			/** @var Region $_region */
			return !$_region->hasSuperRegion();
		});

		if( count($uninitialized_regions) > 0 )
		{
			throw InitializationException::MapInitializationFailed();
		}

		foreach( $this->_preInitNeighbors as $_region_id => $_neighbor_region_id )
		{
			/** @var Region $_region */
			$_region = $this->_region->offsetGet($_region_id);

			if( is_null($_region) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			foreach( $_neighbor_region_id as $__neighbor_region_id )
			{
				/** @var Region $_neighbor */
				$__neighbor = $this->_region->offsetGet($__neighbor_region_id);

				if( is_null($__neighbor) )
				{
					throw InitializationException::MapInitializationFailed();
				}

				$_region->addNeighbor($__neighbor);
			}
		}

		foreach( $this->_preInitWastelands as $_region_id )
		{
			/** @var Region $_region */
			$_region = $this->_region->offsetGet($_region_id);

			if( is_null($_region) )
			{
				throw InitializationException::MapInitializationFailed();
			}

			$_region->setWasteland();
		}

		$this->setInitialized();
	}

	/**
	 * @param integer $id              unique region id
	 * @param integer $super_region_id id of the associated super region
	 *
	 * @throws InitializationException
	 *
	 */
	public function addRegion($id, $super_region_id)
	{
		if( $this->_region->offsetExists($id) )
		{
			throw InitializationException::RegionAlreadyExists($id);
		}

		$this->_region->offsetSet($id, new Region($id));

		$this->_preInitSuperRegionMapping[ $id ] = $super_region_id;
	}

	/**
	 * @param integer $id           unique super region id
	 * @param integer $bonus_armies [optional] reward bonus armies, if all regions of this super region is occupied by one player
	 *
	 * @throws InitializationException
	 *
	 */
	public function addSuperRegion($id, $bonus_armies = 0)
	{
		if( $this->hasSuperRegion($id) )
		{
			throw InitializationException::SuperRegionAlreadyExists($id);
		}

		$this->_superRegion->offsetSet($id, new SuperRegion($id, $bonus_armies));
	}

	/**
	 * @param integer   $id           id of the region
	 * @param integer[] $neighbour_id of neighbour regions
	 *
	 * @author   Falko Matthies <falko.m@web.de>
	 */
	public function addNeighbors($id, $neighbour_id)
	{
		$this->_preInitNeighbors->offsetSet($id, $neighbour_id);
	}

	/**
	 * 
	 * @return LoadedArray
	 * 
	 */
	public function getNeighbors()
	{
		return $this->_preInitNeighbors;
	}

	/**
	 * @param integer $id id of the wasteland region
	 *
	 */
	public function addWasteland($id)
	{
		$this->_preInitWastelands->append($id);
	}

	/**
	 * @return LoadedArray
	 * 
	 */
	public function getWastelands()
	{
		return $this->_preInitWastelands;
	}
}