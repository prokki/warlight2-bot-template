<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot;
use Prokki\Warlight2BotTemplate\Game\Move\PlaceMove;

/**
 * Class GoPlaceArmiesCommand handles
 * - the request to return his place armies moves and
 * - the response to place armies.
 *
 * Request: `go place_armies -t` with time to set the armies
 *
 * Response: `[-b place_armies -i -i, ...]` with bot name, region id and number of armies.
 *
 * Example:
 * ```
 * -> go place_armies 10000
 * <- player1 place_armies 1 2, player1 place_armies 2 5
 * ```
 *
 * @package Prokki\Warlight2BotTemplate
 */
class GoPlaceArmiesCommand extends SetGlobalTimeComputableCommand
{
	/**
	 * @inheritdoc
	 */
	public function compute(Bot $bot)
	{
		$moves = array();

		foreach( $bot->getPlaceMoves() as $_move )
		{
			/** @var PlaceMove $_move */
			array_push($moves, $_move->_toResponseString($bot->getEnvironment()->getPlayer()->getName()));
		}

		return empty($moves) ? 'No moves' : implode(', ', $moves);
	}
}