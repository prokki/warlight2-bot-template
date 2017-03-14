<?php

namespace Prokki\Warlight2BotTemplate\Game\Move;

class PlaceMove extends PickMove
{
	/**
	 * the amount of armies to place on the region with id {@see \Prokki\Warlight2BotTemplate\Game\Move\PickMove::_destinationRegionId}
	 *
	 * @var integer
	 */
	protected $_armies = 0;

	/**
	 * PlaceMove constructor.
	 *
	 * @inheritdoc
	 *
	 * @param integer $armies
	 */
	public function __construct($destination_region, $armies)
	{
		parent::__construct($destination_region);

		$this->_armies = $armies;
	}

	/**
	 * Returns the amount of armies to place on the region with id {@see \Prokki\Warlight2BotTemplate\Game\Move\PickMove::_destinationRegionId}.
	 *
	 * @return integer
	 */
	public function getArmies()
	{
		return $this->_armies;
	}

	/**
	 * @inheritdoc
	 */
	public function _toResponseString($player_name)
	{
		return sprintf("%s place_armies %d %s", $player_name, $this->_destinationRegionId, $this->_armies);
	}
}