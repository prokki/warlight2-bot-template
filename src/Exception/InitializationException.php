<?php

namespace Prokki\Warlight2BotTemplate\Exception;

/**
 * Class RuntimeException
 *
 * @package Prokki\Warlight2BotTemplate
 */
class InitializationException extends \Exception
{
	/**
	 * @return InitializationException
	 */
	public static function MapNotInitialized()
	{
		return new self("The map is not initialized yet. Please call Map::initialize() first.", 201);
	}

	/**
	 * @return InitializationException
	 */
	public static function MapAlreadyInitialized()
	{
		return new self("The map was already initialized.", 202);
	}

	/**
	 * @return InitializationException
	 */
	public static function MapInitializationFailed()
	{
		return new self("Not all regions could be initialized.", 203);
	}

	/**
	 * @param integer $region_id
	 *
	 * @return InitializationException
	 */
	public static function RegionAlreadyExists($region_id)
	{
		return new self(sprintf("The region with ID %d was already added.", $region_id), 211);
	}

	/**
	 * @param integer $super_region_id
	 *
	 * @return InitializationException
	 */
	public static function SuperRegionAlreadyExists($super_region_id)
	{
		return new self(sprintf("The super region with ID %d was already added.", $super_region_id), 221);
	}

	/**
	 *
	 * @param string $method
	 *
	 * @return InitializationException
	 */
	public static function CallMethodOnlyOnRoundZero($method)
	{
		return new self(sprintf("The %s() method is only allowed on the first round.", $method), 231);
	}
}