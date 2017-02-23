<?php

namespace Prokki\Warlight2BotTemplate\Game;

class RoundArray extends \ArrayObject
{
	use Filterable;

	/**
	 * latest round
	 *
	 * @var integer
	 */
	protected $_maxRound = -1;

	public function addRound()
	{
		++$this->_maxRound;
		$this->offsetSet($this->_maxRound, new Round($this->_maxRound));
	}

	/**
	 * @param Map $map
	 *
	 * @return $this
	 */
	public function setInitialMap(Map $map)
	{
		/** @var Round $round */
		$round = $this->offsetGet($this->_maxRound);
		$round->setInitialMap($map);

		return $this;
	}

	/**
	 * @param Map $map
	 *
	 * @return $this
	 */
	public function setUpdatedMap(Map $map)
	{
		/** @var Round $round */
		$round = $this->offsetGet($this->_maxRound);
		$round->setUpdatedMap($map);

		return $this;
	}

	/**
	 * @param (PlaceMove|TransferMove|AttackMove)[] $map
	 *
	 * @return $this
	 */
	public function addMoves($moves)
	{
		/** @var Round $round */
		$round = $this->offsetGet($this->_maxRound);
		$round->addMoves($moves);

		return $this;
	}


	/**
	 * @param (PlaceMove|TransferMove|AttackMove)[] $map
	 *
	 * @return $this
	 */
	public function addOpponentMoves($moves)
	{
		/** @var Round $round */
		$round = $this->offsetGet($this->_maxRound);
		$round->addOpponentMoves($moves);

		return $this;
	}
}