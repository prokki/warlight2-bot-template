<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\GamePlay\AIable;

/**
 * @since  2017-02-14
 *
 */
class Player
{
	/**
	 * @var AIable
	 */
	protected $_ai = null;

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
	 * Player constructor.
	 */
	public function __construct()
	{
		$this->_setting = new Setting();
		$this->_map     = new SetupMap();
	}

	/**
	 * @return Setting
	 *
	 */
	public function getSetting()
	{
		return $this->_setting;
	}

	/**
	 * @return Map
	 *
	 */
	public function getMap()
	{
		return $this->_map;
	}

	/**
	 * @return AIable
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function getAi()
	{
		return $this->_ai;
	}

	/**
	 * @param AIable $ai
	 *
	 * @return static
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	protected function _assignAI($ai)
	{
		$this->_ai = $ai;
		return $this;
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