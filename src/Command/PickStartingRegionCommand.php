<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Exception\ParserException;
use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\RegionState;

/**
 * Class PickStartingRegionCommand handles
 * - the request to be chose a starting region and
 * - the response to place armies.
 *
 * Request: `pick_starting_region -t [-i ...]` with time to place the armies and a list of region ids to chose from
 *
 * Response: `-i` the chosen id of a region
 *
 * Example:
 * ```pick_starting_region 10000 2 4
 * 4```
 *
 * @package Prokki\Warlight2BotTemplate
 */
class PickStartingRegionCommand extends ReceivableCommand implements ApplicableCommand, SendableCommand
{
	/**
	 * the value associative array: the even argument is the key, the odd one the value
	 *
	 * @var integer
	 */
	protected $_time = 0;

	/**
	 *
	 *
	 * @var integer[]
	 */
	protected $_region_ids = array();

	/**
	 * @inheritdoc
	 */
	protected function _parseArguments($input, $arguments)
	{
		$values = array_map('intval', preg_split('/\s+/', $arguments));

		if( count($values) < 2 )
		{
			throw ParserException::CommandMissingArguments($input, 'At least two parameter are necessary: The remaining time and at least one region to pick from.');
		}

		$this->_time = array_shift($values);

		$this->_region_ids = $values;
	}

	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->setGlobalTime($this->_time);

		$this->_setOpponentRegions($player->getMap(), $player->getSetting()->getStartingRegions(), $this->_region_ids);
	}

	/**
	 * @param Map       $map
	 * @param integer[] $starting_region
	 * @param integer[] $available_region
	 *
	 * @throws \Prokki\Warlight2BotTemplate\Exception\InitializationException
	 */
	protected function _setOpponentRegions($map, $starting_region, $available_region)
	{
		$unavailable_regions = array_diff($starting_region, $available_region);

		foreach( $unavailable_regions as $_region_id )
		{
			$region = $map->getRegion($_region_id);

			if( !in_array($region->getState()->getOwner(), [RegionState::OWNER_ME, RegionState::OWNER_OPPONENT]) )
			{
				$region->getState()->setOwner(RegionState::OWNER_OPPONENT);
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	public function compute($player)
	{
		$picked_region_id = $player->getAi()->pickStartingRegion($player, $this->_region_ids);

		return $picked_region_id;
	}
}