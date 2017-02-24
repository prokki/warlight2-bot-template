<?php

namespace Prokki\Warlight2BotTemplate\GamePlay;

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
		$this->_sourceRegionId = $source_region_id;
		parent::__construct($destination_region_id, $armies);
	}

	/**
	 * @return integer
	 */
	public function getSourceRegionId()
	{
		return $this->_sourceRegionId;
	}
}