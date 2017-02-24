<?php

namespace Prokki\Warlight2BotTemplate\Game\Move;

use Prokki\Warlight2BotTemplate\Game\Player;

/**
 * A PickMove represents a move of request `pick_starting_region` (see {@see \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand}).
 *
 * @package Prokki\Warlight2BotTemplate
 */
class PickMove implements Move
{
	/**
	 * the id of the destination region to pick / to set armies
	 *
	 * @var integer
	 */
	protected $_destinationRegionId = 0;

	/**
	 * PickMove constructor.
	 *
	 * @param integer $destination_region_id
	 */
	public function __construct($destination_region_id)
	{
		$this->_destinationRegionId = $destination_region_id;
	}

	/**
	 * Returns the id of the destination region to pick / to set armies.
	 *
	 * @return integer
	 */
	public function getDestinationRegionId()
	{
		return $this->_destinationRegionId;
	}

	/**
	 * @inheritdoc
	 */
	public function _toResponseString($player_name)
	{
		return sprintf("%d", $this->getDestinationRegionId());
	}
}