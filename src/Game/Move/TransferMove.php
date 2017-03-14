<?php

namespace Prokki\Warlight2BotTemplate\Game\Move;

use Prokki\Warlight2BotTemplate\Game\Region;

class TransferMove extends PlaceMove
{
	/**
	 * @var integer
	 */
	protected $_sourceRegionId = 0;

	/**
	 * PlaceMove constructor.
	 *
	 * @param integer|Region $source_region
	 *
	 * @inheritdoc
	 */
	public function __construct($source_region, $destination_region, $armies)
	{
		parent::__construct($destination_region, $armies);

		$this->_sourceRegionId = is_integer($source_region) ? $source_region : $source_region->getId();
	}

	/**
	 * @return integer
	 */
	public function getSourceRegionId()
	{
		return $this->_sourceRegionId;
	}

	/**
	 * @inheritdoc
	 */
	public function _toResponseString($player_name)
	{
		return sprintf("%s attack/transfer %d %d %d",
			$player_name,
			$this->_sourceRegionId,
			$this->_destinationRegionId,
			$this->_armies
		);
	}

	/**
	 * Returns the transfer move as converted attack move.
	 *
	 * @return AttackMove
	 */
	public function toAttackMove()
	{
		return new AttackMove($this->_sourceRegionId, $this->_destinationRegionId, $this->_armies);
	}
}