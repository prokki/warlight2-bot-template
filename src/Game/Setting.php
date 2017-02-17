<?php

namespace Prokki\Warlight2BotTemplate\Game;

/**
 * @since  2017-02-14
 * @author Falko Matthies <falko.m@web.de>
 */
class Setting
{
	/**
	 * the name of your bot
	 *
	 * @var string
	 */
	protected $_name = "";

	/**
	 * the name of your opponent bot
	 *
	 * @var string
	 */
	protected $_nameOpponent = "";

	/**
	 * the maximum (and initial) amount of time in the timebank in total [ms]
	 *
	 * @var integer
	 */
	protected $_timebank = 0;

	/**
	 * the amount of time that is added to your timebank each time a move is requested [ms]
	 *
	 * @var integer
	 */
	protected $_timePerMove = 0;

	/**
	 * the amount of armies your bot can place on the map at the start of this round
	 *
	 * @var integer
	 */
	protected $_startingArmies = 0;

	/**
	 * the maximum amount of rounds in this game - when this number is reached it's a draw
	 *
	 * @var integer
	 */
	protected $_maxRounds = 0;

	/**
	 * the amount of regions your bot can pick from {@see BotSettings::_startingRegions}
	 *
	 * @var integer
	 */
	protected $_startingPickAmount = 0;


	/**
	 * complete list of starting regions your bot can pick from
	 *
	 * @var integer[]
	 */
	protected $_startingRegions = array();

	/**
	 * Returns the name of your bot.
	 *
	 * @return string
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * Returns the name of the opponent bot.
	 *
	 * @return string name of the bot
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getNameOpponent()
	{
		return $this->_nameOpponent;
	}

	/**
	 * Returns the maximum (and initial) amount of time in the timebank in total [ms].
	 *
	 * @return integer
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getTimebank()
	{
		return $this->_timebank;
	}

	/**
	 * @return integer
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getStartingArmies()
	{
		return $this->_startingArmies;
	}

	/**
	 * Returns the amount of time that is added to your timebank each time a move is requested [ms].
	 *
	 * @return integer
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getTimePerMove()
	{
		return $this->_timePerMove;
	}

	/**
	 * Returns the maximum amount of rounds in this game. When this number is reached it's a draw.
	 *
	 * @return integer
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getMaxRounds()
	{
		return $this->_maxRounds;
	}

	/**
	 * Returns the amount of regions your bot can pick from {@see BotSettings::_startingRegions}.
	 *
	 * @return integer
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function getStartingPickAmount()
	{
		return $this->_startingPickAmount;
	}

	/**
	 * Returns the complete list of starting regions your bot can pick from.
	 *
	 * @return integer[]
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public function getStartingRegions()
	{
		return $this->_startingRegions;
	}


	/**
	 * Sets the name of your bot.
	 *
	 * @param string $name name of the bot
	 *
	 * @return Setting
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setName($name)
	{
		$this->_name = $name;
		return $this;
	}

	/**
	 * Sets the name of the opponent bot.
	 *
	 * @param string $name name of the bot
	 *
	 * @return Setting
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setNameOpponent($name)
	{
		$this->_nameOpponent = $name;
		return $this;
	}


	/**
	 * Sets the maximum (and initial) amount of time in the timebank in total [ms].
	 *
	 * @param integer $time time [ms]
	 *
	 * @return Setting
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setTimebank($time)
	{
		$this->_timebank = $time;
		return $this;
	}


	/**
	 * @param integer $startingArmies
	 *
	 * @return Setting
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setStartingArmies($startingArmies)
	{
		$this->_startingArmies = $startingArmies;
		return $this;
	}

	/**
	 * Sets the amount of time that is added to your timebank each time a move is requested [ms].
	 *
	 * @param integer $time time [ms]
	 *
	 * @return Setting
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setTimePerMove($time)
	{
		$this->_timePerMove = $time;
		return $this;
	}

	/**
	 * Sets the maximum amount of rounds in this game. When this number is reached it's a draw.
	 *
	 * @param integer $amount amount of rounds
	 *
	 * @return Setting
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setMaxRounds($amount)
	{
		$this->_maxRounds = $amount;
		return $this;
	}

	/**
	 * Sets the amount of regions your bot can pick from {@see BotSettings::_startingRegions}.
	 *
	 * @param integer $amount amount of regions
	 *
	 * @return Setting
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setStartingPickAmount($amount)
	{
		$this->_startingPickAmount = $amount;
		return $this;
	}

	/**
	 * Sets the complete list of starting regions your bot can pick from.
	 *
	 * @param integer[] $region_id
	 */
	public function setStartingRegions($region_id)
	{
		$this->_startingRegions = $region_id;
	}


}