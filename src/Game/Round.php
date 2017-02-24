<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\GamePlay\AttackMove;
use Prokki\Warlight2BotTemplate\GamePlay\PlaceMove;

class Round
{
	/**
	 * @var integer
	 */
	protected $_no = 0;

	/**
	 * @var Map
	 */
	protected $_mapBefore = null;

	/**
	 * @var (PlaceMove|TransferMove|AttackMove)[]
	 */
	protected $_moves = array();

	/**
	 * @var (PlaceMove|TransferMove|AttackMove)[]
	 */
	protected $_opponentMoves = array();

	/**
	 * @var Map
	 */
	protected $_mapAfter = null;

	/**
	 * Round constructor.
	 *
	 * @param     $no
	 */
	public function __construct($no)
	{
		$this->_no = $no;
	}

	/**
	 * Sets my moves.
	 *
	 * @param (PlaceMove|TransferMove|AttackMove)[] $moves
	 *
	 * @return $this
	 */
	public function addMoves($moves)
	{
		$this->_moves = array_merge($this->_moves, $moves);
		return $this;
	}

	/**
	 * Sets detected opponent moves.
	 *
	 * @param (PlaceMove|TransferMove|AttackMove)[] $moves
	 *
	 * @return $this
	 */
	public function addOpponentMoves($moves)
	{
		$this->_opponentMoves = array_merge($this->_opponentMoves, $moves);
		return $this;
	}

	/**
	 * Sets detected opponent moves.
	 *
	 * @param Map $map
	 *
	 * @return $this
	 */
	public function setInitialMap(Map $map)
	{
		$this->_mapBefore = $map;
		return $this;
	}

	/**
	 * Sets detected opponent moves.
	 *
	 * @param Map $map
	 *
	 * @return $this
	 */
	public function setUpdatedMap(Map $map)
	{
		$this->_mapAfter = $map;
		return $this;
	}

	/**
	 * @return Map
	 */
	public function getUpdatedMap()
	{
		return $this->_mapAfter;
	}
}