<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\Exception\InitializationException;

class Region
{
	/**
	 * @var integer
	 */
	protected $_id = 0;

	/**
	 * @var SuperRegion
	 */
	protected $_superRegion = null;

	/**
	 * @var RegionArray
	 */
	protected $_neighbors = null;

	/**
	 * @var RegionState
	 */
	protected $_state = null;

	/**
	 * Region constructor.
	 *
	 * @param integer $id unique region id
	 */
	public function __construct($id)
	{
		$this->_id = $id;

		$this->_state     = EnvironmentFactory::Get()->newRegionState();
		$this->_neighbors = EnvironmentFactory::Get()->newRegionArray();
	}

	/**
	 * Attention: Call only from _initializeRegions()
	 *
	 * @param SuperRegion $super_region
	 *
	 * @return $this
	 */
	public function »assignSuperRegion($super_region)
	{
		$this->_superRegion = $super_region;

		$this->_superRegion->getRegions()->add($this);

		return $this;
	}

	/**
	 * @return integer
	 *
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * @return SuperRegion
	 */
	public function getSuperRegion()
	{
		return $this->_superRegion;
	}

	/**
	 * Adds a region as neighbor.
	 *
	 * @param Region  $region     the region to add as neighbor
	 * @param boolean $vice_versa [optional] `true` to add this object as neighbor for the submitted region, else `false`, default is `true`
	 *
	 * @throws InitializationException
	 *
	 * @return $this
	 */
	public function addNeighbor($region, $vice_versa = true)
	{
		$this->_neighbors->add($region);

		if( $vice_versa )
		{
			$region->addNeighbor($this, false);
		}

		return $this;
	}

	/**
	 * Returns all neighbor regions.
	 *
	 * @return RegionArray
	 */
	public function getNeighbors()
	{
		return $this->_neighbors;
	}

	/**
	 * Returns the state (fog, owner, armies).
	 *
	 * *Attention*: Call method only by {@see \Prokki\Warlight2BotTemplate\Game\Map::__clone()} method and during the ap setup process to set state properties.
	 *
	 * @return RegionState
	 */
	public function »getState()
	{
		return $this->_state;
	}

	/**
	 *
	 * ATTENTION: Call this method only on round 0.
	 *
	 * @return $this
	 *
	 * @throws InitializationException
	 */
	public function setWasteland()
	{
		return $this->disableFog(6, RegionState::OWNER_NEUTRAL);
	}

	/**
	 * @param integer $armies
	 * @param integer $owner
	 *
	 * @return $this
	 */
	public function disableFog($armies, $owner)
	{
		$this->»getState()->setFog(false)->setArmies($armies)->setOwner($owner);

		return $this;
	}

	/**
	 *
	 * @return $this
	 */
	public function enableFog()
	{
		$this->»getState()->setFog()->setArmies(1)->setOwner(RegionState::OWNER_UNKNOWN);

		return $this;
	}

	/**
	 * Sets the state.
	 *
	 * Attention: Call method only by {@see \Prokki\Warlight2BotTemplate\Game\Map::__clone()} method.
	 *
	 * @param RegionState $state
	 *
	 * @return $this
	 */
	public function »setState($state)
	{
		$this->_state = $state;

		return $this;
	}

	/**
	 * Returns `true` if the region is located in fog, else `false`.
	 *
	 * Wrapper method for {@see \Prokki\Warlight2BotTemplate\Game\Region::getState()}::{@see \Prokki\Warlight2BotTemplate\Game\RegionState::isFog()}.
	 *
	 * @return boolean
	 */
	public function isFog()
	{
		return $this->_state->isFog();
	}

	/**
	 * Returns the current owner of the region.
	 *
	 * Wrapper method for {@see \Prokki\Warlight2BotTemplate\Game\Region::getState()}::{@see \Prokki\Warlight2BotTemplate\Game\RegionState::getOwner()}.
	 *
	 * @return integer
	 */
	public function getOwner()
	{
		return $this->_state->getOwner();
	}

	/**
	 * Returns the armies placed on the region.
	 *
	 * Wrapper method for {@see \Prokki\Warlight2BotTemplate\Game\Region::getState()}::{@see \Prokki\Warlight2BotTemplate\Game\RegionState::getArmies()}.
	 *
	 * @return integer
	 */
	public function getArmies()
	{
		return $this->_state->getArmies();
	}

}