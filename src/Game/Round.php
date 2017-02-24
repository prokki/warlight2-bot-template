<?php

namespace Prokki\Warlight2BotTemplate\Game;

use Prokki\Warlight2BotTemplate\Game\Move\AttackMove;
use Prokki\Warlight2BotTemplate\Game\Move\PickMove;
use Prokki\Warlight2BotTemplate\Game\Move\PlaceMove;
use Prokki\Warlight2BotTemplate\Game\Move\TransferMove;

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
	 * @var PickMove[]|PlaceMove[]|TransferMove[]|AttackMove[]
	 */
	protected $_moves = array();

	/**
	 * @var PickMove[]|PlaceMove[]|TransferMove[]|AttackMove[]
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
	 * Adds add move as my move.
	 *
	 * @param PickMove|PlaceMove|TransferMove|AttackMove $move
	 *
	 * @return $this
	 */
	public function addMove($move)
	{
		array_push($this->_moves, $move);
		return $this;
	}

	/**
	 * Adds my moves.
	 *
	 * @param PickMove[]|PlaceMove[]|TransferMove[]|AttackMove[] $moves
	 *
	 * @return $this
	 */
	public function addMoves($moves)
	{
		$this->_moves = array_merge($this->_moves, $moves);
		return $this;
	}

	/**
	 * Adds an opponent move.
	 *
	 * @param PickMove|PlaceMove|TransferMove|AttackMove $move
	 *
	 * @return $this
	 */
	public function addOpponentMove($move)
	{
		array_push($this->_opponentMoves, $move);
		return $this;
	}

	/**
	 * Sets detected opponent moves.
	 *
	 * @param PickMove[]|PlaceMove[]|TransferMove[]|AttackMove[] $moves
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

	/**
	 * @return PickMove[]|PlaceMove[]|TransferMove[]|AttackMove[]
	 */
	public function getMoves()
	{
		return $this->_moves;
	}

	/**
	 * @return PickMove[]|PlaceMove[]|TransferMove[]|AttackMove[]
	 */
	public function getOpponentMoves()
	{
		return $this->_opponentMoves;
	}
}