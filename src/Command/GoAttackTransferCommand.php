<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\GamePlay\TransferMove;

/**
 * Class GoAttackTransferCommand handles
 * - the request to return his attack and/or transfer moves and
 * - the response all attack/transfer moves.
 *
 * Request: `go attack/transfer -t` with time to set the armies
 *
 * Response: `[-b attack/transfer -i -i -i, ...]` with bot name, source region, target region, number of armies
 *
 * Example:
 * ```go attack/transfer 10000
 * player1 attack/transfer 1 2 3, player1 attack/transfer 2 3 8```
 *
 * @package Prokki\Warlight2BotTemplate
 *
 * @todo    test is missing
 */
class GoAttackTransferCommand extends ReceivableIntCommand implements ApplicableCommand, SendableCommand
{
	/**
	 * @inheritdoc
	 */
	public function apply(Player $player, SetupMap $map)
	{
		$player->setGlobalTime($this->_value);
	}

	/**
	 * @inheritdoc
	 */
	public function compute($ai, Player $player, Map $map)
	{
		$moves = array();

		foreach( $ai->getAttackTransferMoves($player, $map) as $_move )
		{
			/** @var TransferMove $_move */
			array_push($moves, sprintf("%s attack/transfer %d %d %d",
				$player->getName(),
				$_move->getSourceRegionId(),
				$_move->getDestinationRegionId(),
				$_move->getArmies()
			));
		}

		return empty($moves) ? 'No moves' : implode(', ', $moves);
	}
}