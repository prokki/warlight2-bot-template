<?php

namespace Prokki\Warlight2BotTemplate\Game;

/**
 * Class SuperRegion
 *
 * SuperRegion does not extend RegionArray to use the advantage of the {@see \Prokki\Warlight2BotTemplate\Game\EnvironmentFactory},
 * see property {\Prokki\Warlight2BotTemplate\Game\SuperRegion::_regions}.
 *
 * @package Prokki\Warlight2BotTemplate
 *
 * @todo    maybe remove method hasRegion() (and replace my getRegions()->has())
 */
class SuperRegion implements SupraRegional
{

	/**
	 * @var integer
	 */
	protected $_id = 0;

	/**
	 * @var integer
	 */
	protected $_bonusArmies = 0;

	/**
	 * @var RegionArray
	 */
	protected $_regions = null;

	/**
	 * SuperRegion constructor.
	 *
	 * @param integer $id           unique super region id
	 * @param integer $bonus_armies reward bonus armies, if all regions of this super region is occupied by one player
	 */
	public function __construct($id, $bonus_armies)
	{
		$this->_id          = $id;
		$this->_bonusArmies = $bonus_armies;
		$this->_regions     = EnvironmentFactory::Get()->newRegionArray();
	}

	/**
	 * @return integer
	 *
	 */
	public function getBonusArmies()
	{
		return $this->_bonusArmies;
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
	 * @inheritdoc
	 */
	public function hasRegion($region)
	{
		return $this->_regions->has($region);
	}

	/**
	 * @return RegionArray
	 */
	public function getRegions()
	{
		return $this->_regions;
	}

	/**
	 * Returns `true` if the super regions has at least one region that is owned by the submitted owner.
	 *
	 * @param integer $owner one of the `RegionState::OWNER_` constants
	 *
	 * @return boolean
	 */
	public function isOccupiedByOwner($owner)
	{
		return count($this->_regions->filterOwner($owner)) > 0;
	}

	/**
	 * Returns `true` if all regions of the super regions is owned by the submitted owner.
	 *
	 * @param integer $owner one of the `RegionState::OWNER_` constants
	 *
	 * @return boolean
	 */
	public function isFullyOccupiedByOwner($owner)
	{
		return count($this->_regions->filterOwner($owner)) === count($this->_regions);
	}

	/**
	 * Returns `true` if all regions of the super regions is owned either by ME or by the OPPONENT, else `false`.
	 *
	 * @return boolean
	 */
	public function isFullyOccupied()
	{
		return $this->isFullyOccupiedByOwner(RegionState::OWNER_ME) || $this->isFullyOccupiedByOwner(RegionState::OWNER_OPPONENT);
	}
}