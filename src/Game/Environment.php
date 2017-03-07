<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\TheaigamesBotEngine\Game\RoundBasedEnvironment;

class Environment extends RoundBasedEnvironment
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
	 * Environment constructor.
	 *
	 * @inheritdoc
	 */
	public function __construct($max_rounds = 0)
	{
		$this->_player = EnvironmentFactory::Get()->newPlayer();
		$this->_map    = EnvironmentFactory::Get()->newMap();

		parent::__construct();
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
	 * Overrides... to reference updated map of old round as initial map of new round.
	 *
	 * @inheritdoc
	 */
	public function addRound()
	{
		// call parent method
		/** @var Round $new_round */
		$new_round = parent::addRound();

		// reference map of old round as initial map of new round
		return $new_round->setInitialMap(clone $this->_map);
	}
}