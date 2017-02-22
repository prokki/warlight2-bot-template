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
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function setGlobalTime($globalTime)
	{
		$this->_globalTime = $globalTime;
		return $this;
	}

	/**
	 * @return integer
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function getGlobalTime()
	{
		return $this->_globalTime;
	}

}