<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Exception\ParserException;
use Prokki\Warlight2BotTemplate\Game\Environment;

/**
 * Class PickStartingRegionCommand handles
 * - the request to be chose a starting region and
 * - the response to place armies.
 *
 * Request: `pick_starting_region -t [-i ...]` with time to place the armies and a list of region ids to chose from
 *
 * Response: `-i` the chosen id of a region
 *
 * Example:
 * ```
 * -> pick_starting_region 10000 2 4
 * <- 4
 * ```
 *
 * @package Prokki\Warlight2BotTemplate
 */
class PickStartingRegionCommand extends ReceivableCommand implements Computable
{
	/**
	 * the value associative array: the even argument is the key, the odd one the value
	 *
	 * @var integer
	 */
	protected $_time = 0;

	/**
	 *
	 *
	 * @var integer[]
	 */
	protected $_region_ids = array();

	/**
	 * @inheritdoc
	 */
	protected function _parseArguments($input, $arguments)
	{
		$values = array_map('intval', preg_split('/\s+/', $arguments));

		if( count($values) < 2 )
		{
			throw ParserException::CommandMissingArguments($input, 'At least two parameter are necessary: The remaining time and at least one region to pick from.');
		}

		$this->_time = array_shift($values);

		$this->_region_ids = $values;
	}

	/**
	 * @inheritdoc
	 */
	public function apply(Environment $environment)
	{
		$environment->getPlayer()->setGlobalTime($this->_time);
	}

	/**
	 * Returns region ids which are picked either from me or from the opponent.
	 *
	 * @param integer[] $starting_region
	 *
	 * @return integer[]
	 *
	 * @throws \Prokki\Warlight2BotTemplate\Exception\InitializationException
	 */
	protected function _getAllPickedRegionIds($starting_region)
	{
		if( count($starting_region) === count($this->_region_ids) )
		{
			return array();
		}

		return array_diff($starting_region, $this->_region_ids);
	}

	/**
	 * @inheritdoc
	 */
	public function compute($ai, Environment $environment)
	{
		// 1. get opponent pick moves
		$opponent_pick_moves = $environment->getMap()->getUniqueOpponentPickMoves(
			$this->_getAllPickedRegionIds($environment->getPlayer()->getStartingRegions())
		);
		// and save to current round
		$environment->getCurrentRound()->addOpponentMoves($opponent_pick_moves);

		// 2. calculate my pick move by AI
		$pick_move = $ai->getPickMove($environment, $this->_region_ids);
		// and save to current round
		$environment->getCurrentRound()->addMove($pick_move);

		// return my move as command
		return $pick_move->_toResponseString($environment->getPlayer()->getName());
	}
}