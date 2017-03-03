<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot\Bot;

/**
 * Class SetupMapOpponentStartingRegionsCommand handles
 * - the reception of the region ids the opponent player has chosen
 *
 * Request: `setup_map opponent_starting_regions [-i ...] ` with a whitespace separated list of all region ids
 *
 * Example:
 * ```
 * -> setup_map opponent_starting_regions 7 12 14
 * ```
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SetupMapOpponentStartingRegionsCommand extends ReceivableIntListCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		$opponent_pick_moves = $bot->getEnvironment()->getMap()->getUniqueOpponentPickMoves($this->_value);

		$bot->getEnvironment()->getCurrentRound()->addOpponentMoves($opponent_pick_moves);
	}
}