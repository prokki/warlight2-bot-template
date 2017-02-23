<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\Exception\InitializationException;

class Region
{
	/**
	 * flag to indicate a neutral region
	 */
	const OWNER_NEUTRAL = 1;

	/**
	 * flag to indicate a region occupied by the opponent
	 */
	const OWNER_OPPONENT = 2;

	/**
	 * flag to indicate a region owned by me
	 */
	const OWNER_ME = 3;

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
	 * @param integer     $id unique region id
	 * @param SuperRegion $super_region
	 */
	public function __construct($id, $super_region)
	{
		$this->_id = $id;

		$this->_superRegion = $super_region;

		$this->_state = new RegionState();

		$this->_neighbors = new RegionArray();
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
	 *
	 * @throws InitializationException
	 *
	 */
	public function getSuperRegion()
	{
		if( !$this->hasSuperRegion() )
		{
			throw InitializationException::MapNotInitialized();
		}

		return $this->_superRegion;
	}

	/**
	 * @param SuperRegion $super_region
	 *
	 */
	public function setSuperRegion($super_region)
	{
		if( $this->hasSuperRegion() )
		{
			return;
		}

		$this->_superRegion = $super_region;
		$this->_superRegion->»addRegion($this);
	}

	/**
	 * @return boolean
	 */
	public function hasSuperRegion()
	{
		return !is_null($this->_superRegion);
	}

	/**
	 * Adds a region as neighbor.
	 *
	 * @param Region  $region     the region to add as neighbor
	 * @param boolean $vice_versa [optional] `true` to add this object as neighbor for the submitted region, else `false`, default is `true`
	 *
	 * @throws InitializationException
	 */
	public function addNeighbor($region, $vice_versa = true)
	{
		$this->_neighbors->offsetSet($region->_id, $region);

		if( $vice_versa )
		{
			$region->addNeighbor($this, false);
		}
	}

	/**
	 * @return RegionArray
	 */
	public function getNeighbors()
	{
		return $this->_neighbors;
	}


	/**
	 * @return RegionState
	 */
	public function getState()
	{
		return $this->_state;
	}

	/**
	 *
	 * ATTENTION: Call this method only on round 0.
	 *
	 * @return RegionState
	 *
	 * @throws InitializationException
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function setWasteland()
	{
		return $this->getState()->disableFog(6, self::OWNER_NEUTRAL);
	}

	/**
	 * @param RegionState $state
	 *
	 * @return $this
	 */
	public function setState(RegionState $state)
	{
		$this->_state = $state;
		return $this;
	}
}