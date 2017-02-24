<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\Move\TransferMove;

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
 * ```
 * -> go attack/transfer 10000
 * <- player1 attack/transfer 1 2 3, player1 attack/transfer 2 3 8
 * ```
 *
 * @package Prokki\Warlight2BotTemplate
 */
class GoAttackTransferCommand extends SetGlobalTimeComputableCommand
{
	/**
	 * @inheritdoc
	 */
	public function compute($ai, Environment $environment)
	{
		$moves = array();

		foreach( $ai->getAttackTransferMoves($environment) as $_move )
		{
			/** @var TransferMove $_move */
			array_push($moves, $_move->_toResponseString($environment->getPlayer()->getName()));
		}

		return empty($moves) ? 'No moves' : implode(', ', $moves);
	}

}