<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Game\RoundBasedEnvironmentFactory;

class EnvironmentFactory extends RoundBasedEnvironmentFactory
{

	/**
	 * @return Environment
	 */
	public function newEnvironment()
	{
		return new Environment();
	}

	/**
	 * @param integer $round_no
	 *
	 * @return Round
	 */
	public function newRound($round_no)
	{
		return new Round($round_no);
	}

	/**
	 * @return Player
	 */
	public function newPlayer()
	{
		return new Player();
	}

	/**
	 * @return Map
	 */
	public function newMap()
	{
		return new Map();
	}

	/**
	 * @param integer $region_id
	 *
	 * @return Region
	 */
	public function newRegion($region_id)
	{
		return new Region($region_id);
	}

	/**
	 * @return RegionArray
	 */
	public function newRegionArray()
	{
		return new RegionArray();
	}

	/**
	 * @return RegionState
	 */
	public function newRegionState()
	{
		return new RegionState();
	}

	/**
	 * @param integer $_super_region_id
	 * @param integer $_bonus_armies
	 *
	 * @return SuperRegion
	 *
	 */
	public function newSuperRegion($_super_region_id, $_bonus_armies)
	{
		return new SuperRegion($_super_region_id, $_bonus_armies);
	}

	/**
	 * @return RegionArray
	 */
	public function newSuperRegionArray()
	{
		return new SuperRegionArray();
	}
}