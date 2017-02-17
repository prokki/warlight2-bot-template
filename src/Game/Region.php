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
	 * @var Region[]
	 */
	protected $_neighbors = array();

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

		$this->_state = new RegionState();
	}

	/**
	 * @return integer
	 *
	 * @author Falko Matthies <falko.m@web.de>
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
	 * @author Falko Matthies <falko.m@web.de>
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
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setSuperRegion($super_region)
	{
		if( $this->hasSuperRegion() )
		{
			return;
		}

		$this->_superRegion = $super_region;
		$this->_superRegion->addRegion($this);
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
		$this->_neighbors[ $region->_id ] = $region;

		if( $vice_versa )
		{
			$region->addNeighbor($this, false);
		}
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
}