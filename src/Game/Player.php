<?php

namespace Prokki\Warlight2BotTemplate\Game;

/**
 * @since  2017-02-14
 *
 */
class Player extends Setting
{
	/**
	 * @var integer
	 */
	protected $_globalTime = 0;

	/**
	 * @param integer $globalTime
	 *
	 * @return static
	 */
	public function setGlobalTime($globalTime)
	{
		$this->_globalTime = $globalTime;
		return $this;
	}

	/**
	 * @return integer
	 */
	public function getGlobalTime()
	{
		return $this->_globalTime;
	}

}