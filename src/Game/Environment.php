<?php

namespace Prokki\Warlight2BotTemplate\Game;

class Environment
{
	/**
	 * @var Player
	 */
	protected $_player = null;

	/**
	 * @var Map
	 */
	protected $_map = null;

	/**
	 * latest (actual) round
	 *
	 * @var integer
	 */
	protected $_maxRound = 0;

	/**
	 * @var \ArrayObject
	 */
	protected $_rounds = null;

	public function __construct()
	{
		$this->_player = new Player();
		$this->_map    = new Map();
		$this->_rounds = new \ArrayObject();
	}

	/**
	 * @return Player
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function getPlayer()
	{
		return $this->_player;
	}

	/**
	 * @return Map
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function getMap()
	{
		return $this->_map;
	}


	/**
	 * @return \ArrayObject
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function getRounds()
	{
		return $this->_rounds;
	}

	/**
	 * @return integer
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function getMaxRound()
	{
		return $this->_maxRound;
	}
}