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
	 * current round number
	 *
	 * @var integer
	 */
	protected $_currentRoundNo = 0;

	/**
	 * @var \ArrayObject
	 */
	protected $_rounds = null;

	public function __construct()
	{
		$this->_player = new Player();
		$this->_map    = new Map();
		$this->_rounds = new \ArrayObject();

		$this->_rounds->offsetSet($this->_currentRoundNo, new Round($this->_currentRoundNo));
	}

	/**
	 * @return Player
	 */
	public function getPlayer()
	{
		return $this->_player;
	}

	/**
	 * @return Map
	 */
	public function getMap()
	{
		return $this->_map;
	}

	/**
	 * @return \ArrayObject
	 */
	public function getRounds()
	{
		return $this->_rounds;
	}

	/**
	 * Returns the actual (latest) round.
	 *
	 * @param integer $round_no
	 *
	 * @return Round
	 */
	public function getRound($round_no)
	{
		// TODO check if exists!
		return $this->_rounds->offsetGet($round_no);
	}

	/**
	 * Returns the current round.
	 *
	 * @return Round
	 */
	public function getCurrentRound()
	{
		// TODO check if exists!
		return $this->getRound($this->_currentRoundNo);
	}

	/**
	 * Returns the actual (latest) round number.
	 *
	 * @return integer
	 */
	public function getCurrentRoundNo()
	{
		return $this->_currentRoundNo;
	}

	/**
	 * Returns the current round.
	 *
	 * @return Round
	 */
	public function addRound()
	{
		$old_updated_map = $this->getCurrentRound()->getUpdatedMap();

		++$this->_currentRoundNo;

		$new_round = new Round($this->_currentRoundNo);
		$new_round->setInitialMap($old_updated_map);

		$this->_rounds->offsetSet($this->_currentRoundNo, $new_round);
	}

}