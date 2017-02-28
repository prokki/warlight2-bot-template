<?php

namespace Prokki\Warlight2BotTemplate\Game;

class SuperRegion
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
	 * @var Region[]
	 */
	protected $_region = array();

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
}