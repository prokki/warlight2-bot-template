<?php

namespace Prokki\Warlight2BotTemplate\Game;

/**
 * @since  2017-02-14
 * @author Falko Matthies <falko.m@web.de>
 *
 */
class Player
{
	/**
	 * @var Setting
	 */
	protected $_setting = null;

	/**
	 * @var SetupMap
	 */
	protected $_map = null;

	/**
	 * @var integer
	 */
	protected $_globalTime = 0;

	/**
	 * Warlight2Bot constructor.
	 *
	 */
	public function __construct()
	{
		$this->_setting = new Setting();
		$this->_map     = new SetupMap();
	}

	/**
	 * @return Setting
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getSetting()
	{
		return $this->_setting;
	}

	/**
	 * @return Map
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getMap()
	{
		return $this->_map;
	}

	/**
	 * @param integer $globalTime
	 *
	 * @return static
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function setGlobalTime($globalTime)
	{
		$this->_globalTime = $globalTime;
		return $this;
	}

}