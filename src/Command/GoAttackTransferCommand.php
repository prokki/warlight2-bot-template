<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Map;
use Prokki\Warlight2BotTemplate\Game\Player;
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
 */
class GoAttackTransferCommand extends SetGlobalTimeComputableCommand
{
	/**
	 * @inheritdoc
	 */
	public function compute($ai, Player $player, Map $map)
	{
		$moves = array();

		foreach( $ai->getAttackTransferMoves($player, $map) as $_move )
		{
			/** @var TransferMove $_move */
			array_push($moves, $this->_moveToString($player, $_move));
		}

		return empty($moves) ? 'No moves' : implode(', ', $moves);
	}

	/**
	 * @param Player       $player
	 * @param TransferMove $move
	 *
	 * @return string
	 */
	protected function _moveToString(Player $player, TransferMove $move)
	{
		return sprintf("%s attack/transfer %d %d %d",
			$player->getName(),
			$move->getSourceRegionId(),
			$move->getDestinationRegionId(),
			$move->getArmies()
		);
	}
}