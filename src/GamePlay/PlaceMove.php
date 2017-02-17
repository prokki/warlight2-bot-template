<?php

namespace Prokki\Warlight2BotTemplate\GamePlay;

class PlaceMove
{
	/**
	 * @var integer
	 */
	protected $_destinationRegionId = 0;

	/**
	 * @var integer
	 */
	protected $_armies = 0;

	/**
	 * PlaceMove constructor.
	 *
	 * @param integer $destination_region_id
	 * @param integer $armies
	 */
	public function __construct($destination_region_id, $armies)
	{
		$this->_destinationRegionId = $destination_region_id;
		$this->_armies              = $armies;
	}

	public function __toString()
	{
		return sprintf("%d %d", $this->_destinationRegionId, $this->_armies);
	}
}