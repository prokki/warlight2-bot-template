<?php

namespace Prokki\Warlight2BotTemplate\Game;

/**
 * Interface SupraRegional
 *
 * @package Prokki\Warlight2ProkkiBot
 */
interface SupraRegional
{
	/**
	 * @param Region|integer $region
	 *
	 * @return boolean
	 */
	public function hasRegion($region);

	/**
	 * @return RegionArray
	 */
	public function getRegions();
}