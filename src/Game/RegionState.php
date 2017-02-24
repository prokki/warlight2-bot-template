<?php

namespace Prokki\Warlight2BotTemplate\Game;

class RegionState
{
	/**
	 * flag to indicate a region with an unknown owner (i.e. because of the fog)
	 */
	const OWNER_UNKNOWN = 1;

	/**
	 * flag to indicate a neutral region
	 */
	const OWNER_NEUTRAL = 2;

	/**
	 * flag to indicate a region occupied by the opponent
	 */
	const OWNER_OPPONENT = 4;

	/**
	 * flag to indicate a region owned by me
	 */
	const OWNER_ME = 8;

	/**
	 * @var boolean
	 */
	protected $_fog = false;

	/**
	 * @var integer
	 */
	protected $_owner = self::OWNER_NEUTRAL;

	/**
	 * @var integer
	 */
	protected $_armies = 2;

	/**
	 * @return boolean
	 */
	public function isFog()
	{
		return $this->_fog;
	}

	/**
	 * @return integer
	 */
	public function getOwner()
	{
		return $this->_owner;
	}

	/**
	 * @return integer
	 */
	public function getArmies()
	{
		return $this->_armies;
	}

	/**
	 * @param boolean $fog
	 *
	 * @return RegionState
	 */
	public function setFog($fog)
	{
		$this->_fog = $fog;
		return $this;
	}

	/**
	 * @param integer $owner
	 *
	 * @return RegionState
	 *
	 */
	public function setOwner($owner)
	{
		// switch from ME/OPPONENT to UNKNOWN/NEUTRAL is permitted!
		if( in_array($owner, [self::OWNER_UNKNOWN, self::OWNER_NEUTRAL]) && in_array($this->_owner, [self::OWNER_ME, self::OWNER_OPPONENT]) )
		{
			return $this;
		}

		$this->_owner = $owner;
		return $this;
	}

	/**
	 * @param integer $armies
	 *
	 * @return RegionState
	 */
	public function setArmies($armies)
	{
		$this->_armies = $armies;
		return $this;
	}

	/**
	 * @param integer $armies
	 * @param integer $owner
	 *
	 * @return RegionState
	 */
	public function disableFog($armies, $owner)
	{
		return $this->setArmies($armies)->setOwner($owner);
	}

	/**
	 *
	 * @return RegionState
	 */
	public function enableFog()
	{
		return $this->setArmies(1)->setOwner(self::OWNER_UNKNOWN);
	}
}