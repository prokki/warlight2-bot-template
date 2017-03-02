<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Util\ArrayObject\LoadedArray;
use Prokki\Warlight2BotTemplate\Exception\InitializationException;
use Prokki\Warlight2BotTemplate\Exception\RuntimeException;

/**
 * This class is used for two cases:
 * 1. To encapsulate starting `setup map` requests from common map behavior (i.e. {@see \Prokki\Warlight2BotTemplate\Game\Map::getRegions()}.
 * 2. To ensure the map cn be cloned with copied object (instead of same references)
 *    by calling {@see \Prokki\Warlight2BotTemplate\Game\Map::initialize()}.
 *
 * @package Prokki\Warlight2BotTemplate\Game
 */
class SetupMap
{
	/**
	 * the id of all super regions with their assigned amount of bonus armies
	 *
	 * example:
	 * ```php
	 * array(
	 *    [1] => 7,       // super region with id 1 has 7 bonus armies
	 *    [2] => 5,       // super region with id 2 has 5 bonus armies
	 *    [...]
	 * )
	 * ```
	 *
	 * @var LoadedArray
	 */
	protected $_superRegionIds = null;

	/**
	 * all region id mapped to their related super region id
	 *
	 * example:
	 * ```php
	 * array(
	 *    [3] => array(     // super region with id 3 has
	 *        1,            //   region 1 and
	 *        2,            //   region 2
	 *    ),
	 *    [...]
	 * )
	 * ```
	 *
	 * @var LoadedArray
	 */
	protected $_regionIds = array();

	/**
	 * all region ids marked as neighbors of another region (id)
	 *
	 * example:
	 * ```php
	 * array(
	 *    [1] => array(2,7),     // regions 2 and 7 are neighbors of region 1
	 *    [2] => array(1,7),     // regions 1 and 7 are neighbors of region 2
	 *    [7] => array(1,2),     // regions 1 and 2 are neighbors of region 7
	 * )
	 * ```
	 *
	 * @var LoadedArray
	 */
	protected $_neighborRegionIds = array();

	/**
	 * all regions ids marked as wasteland
	 *
	 * @var LoadedArray
	 */
	protected $_wastelandIds = array();

	/**
	 * @var boolean
	 */
	protected $_initialized = false;

	public function __construct()
	{
		$this->_superRegionIds    = new LoadedArray();
		$this->_regionIds         = new LoadedArray();
		$this->_neighborRegionIds = new LoadedArray();
		$this->_wastelandIds      = new LoadedArray();
	}

	/**
	 * @param integer $super_region_id super region id
	 * @param integer $bonus_armies    [optional] reward bonus armies, if all regions of this super region is occupied by one player
	 *
	 * @throws InitializationException
	 *
	 */
	public function addSuperRegion($super_region_id, $bonus_armies = 0)
	{
		// if $this->_superRegionIds->setLoaded() throw!
		if( $this->_superRegionIds->offsetExists($super_region_id) )
		{
			throw InitializationException::SuperRegionAlreadyExists($super_region_id);
		}

		$this->_superRegionIds->offsetSet($super_region_id, $bonus_armies);
	}

	/**
	 * @param integer $region_id       unique region id
	 * @param integer $super_region_id id of the associated super region
	 *
	 * @throws InitializationException
	 */
	public function addRegion($region_id, $super_region_id)
	{
		$regions = $this->_regionIds->offsetExists($super_region_id) ? $this->_regionIds->offsetGet($super_region_id) : array();

		// if $this->_superRegionIds->setLoaded() throw!
		if( in_array($region_id, $regions) )
		{
			throw InitializationException::RegionAlreadyExists($region_id);
		}

		array_push($regions, $region_id);

		$this->_regionIds->offsetSet($super_region_id, $regions);
	}

	/**
	 * @param integer   $region_id            id of the region
	 * @param integer[] $neighbour_region_ids of neighbour regions
	 *
	 * @throws RuntimeException
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function addNeighbors($region_id, $neighbour_region_ids)
	{
		$neighbor_regions = $this->_neighborRegionIds->offsetExists($region_id) ?
			$this->_neighborRegionIds->offsetGet($region_id) :
			array();

		$neighbor_regions = array_unique(array_merge($neighbor_regions, $neighbour_region_ids));

		$this->_neighborRegionIds->offsetSet($region_id, $neighbor_regions);
	}

	/**
	 * @param integer $region_id id of the wasteland region
	 */
	public function addWasteland($region_id)
	{
		$this->_wastelandIds->offsetSet($region_id, $region_id);
	}

	/**
	 * Override this method in class {@see \Prokki\Warlight2BotTemplate\Game\Map} to return `true`.
	 *
	 * @inheritdoc
	 */
	public function initialize()
	{
		return $this->_initialized;
	}

	/**
	 * Tries to initialize the map by calling the {@see \Prokki\Warlight2BotTemplate\Game\Map::initialize()} method.
	 *
	 * The method is only called if all arrays of this object has the flag _loaded_.
	 *
	 * Be sure to call this method if the map is not initialized yet, otherwise an error wil be thrown.
	 *
	 * @return bool
	 *
	 * @throws InitializationException
	 */
	protected function _tryToInitialize()
	{
		if( $this->_initialized )
		{
			throw InitializationException::MapAlreadyInitialized();
		}

		if( !$this->_superRegionIds->isLoaded()
			|| !$this->_regionIds->isLoaded()
			|| !$this->_neighborRegionIds->isLoaded()
			|| !$this->_wastelandIds->isLoaded()
		)
		{
			return false;
		}

		return $this->initialize();
	}

	/**
	 * Adds flag _loaded_ to the super regions array and returns `true` if the complete map could be initialized successfully, else `false`.
	 *
	 * @return boolean
	 */
	public function finishAddingSuperRegions()
	{
		$this->_superRegionIds->setLoaded();

		return $this->_tryToInitialize();
	}

	/**
	 * Adds flag _loaded_ to the regions array and returns `true` if the complete map could be initialized successfully, else `false`.
	 *
	 * @return boolean
	 */
	public function finishAddingRegions()
	{
		$this->_regionIds->setLoaded();

		return $this->_tryToInitialize();
	}

	/**
	 * Adds flag _loaded_ to the neighbors array and returns `true` if the complete map could be initialized successfully, else `false`.
	 *
	 * @return boolean
	 */
	public function finishAddingNeighbors()
	{
		$this->_neighborRegionIds->setLoaded();

		return $this->_tryToInitialize();
	}

	/**
	 * Adds flag _loaded_ to the wasteland array and returns `true` if the complete map could be initialized successfully, else `false`.
	 *
	 * @return boolean
	 */
	public function finishAddingWasteland()
	{
		$this->_wastelandIds->setLoaded();

		return $this->_tryToInitialize();
	}

}