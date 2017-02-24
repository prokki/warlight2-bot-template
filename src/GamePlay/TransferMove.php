<?php

namespace Prokki\Warlight2BotTemplate\GamePlay;

use Prokki\Warlight2BotTemplate\Game\Player;

class TransferMove extends PlaceMove
{
	/**
	 * @var integer
	 */
	protected $_sourceRegionId = 0;

	/**
	 * PlaceMove constructor.
	 *
	 * @param integer $source_region_id
	 *
	 * @inheritdoc
	 */
	public function __construct($source_region_id, $destination_region_id, $armies)
	{
		parent::__construct($destination_region_id, $armies);

		$this->_sourceRegionId = $source_region_id;
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
	public function _toResponseString(Player $player)
	{
		return sprintf("%s attack/transfer %d %d %d",
			$player->getName(),
			$this->getSourceRegionId(),
			$this->getDestinationRegionId(),
			$this->getArmies()
		);
	}

}