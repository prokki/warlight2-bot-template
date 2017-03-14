<?php

namespace Prokki\Warlight2BotTemplate\Game\Move;

use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\Region;

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
	 * @param integer|Region $destination_region
	 */
	public function __construct($destination_region)
	{
		$this->_destinationRegionId = is_integer($destination_region) ? $destination_region : $destination_region->getId();
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
		return sprintf("%d", $this->_destinationRegionId);
	}
}