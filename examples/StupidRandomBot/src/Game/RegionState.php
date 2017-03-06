<?php

namespace Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\Game;

/**
 * Class Map extends {@see \Prokki\Warlight2BotTemplate\Game\RegionState} with new properties.
 * You can add custom properties and related getters/setter to call them from your bot or map methods.
 * *Remember* to include a factory class {@see EnvironmentFactory} to override method {@see \Prokki\Warlight2BotTemplate\Game\EnvironmentFactory::newRegionState()}.
 *
 * The region's state of the StupidRandomBot was extended to indicate the weather of each region.
 * 
 * @package Prokki\Warlight2BotTemplate\StupidRandomBot
 */
class RegionState extends \Prokki\Warlight2BotTemplate\Game\RegionState
{
	/**
	 * @var integer
	 */
	const WEATHER_SUNNY = 0;

	/**
	 * @var integer
	 */
	const WEATHER_CLOUDY = 1;

	/**
	 * @var integer
	 */
	const WEATHER_RAINY = 2;

	/**
	 * @var integer[]
	 */
	protected static $_AllowedWeather = null;

	/**
	 * weather of the region, can change every round
	 *
	 * @var integer
	 */
	protected $_weather = self::WEATHER_SUNNY;

	/**
	 * @return integer[]
	 */
	protected static function _GetAllowedWeathers()
	{
		if( is_null(self::$_AllowedWeather) )
		{
			self::$_AllowedWeather = [self::WEATHER_SUNNY, self::WEATHER_CLOUDY, self::WEATHER_RAINY];
		}
		return self::$_AllowedWeather;
	}

	/**
	 * Returns the weather of the region.
	 *
	 * @return integer
	 */
	public function getWeather()
	{
		return $this->_weather;
	}

	/**
	 * Sets the weather of the region.
	 *
	 * @param integer $weather
	 *
	 * @return RegionState
	 */
	public function setWeather($weather = self::WEATHER_SUNNY)
	{
		$this->_weather = $weather;
		return $this;
	}

	/**
	 * Updates the weather of the region.
	 *
	 * @return RegionState
	 */
	public function updateWeather()
	{
		$allowed_weathers = self::_GetAllowedWeathers();

		mt_srand((double) microtime() * 4711 * $this->getArmies());
		$random_index = mt_rand(0, count($allowed_weathers) - 1);

		$this->setWeather($allowed_weathers[ $random_index ]);

		return $this;
	}
}