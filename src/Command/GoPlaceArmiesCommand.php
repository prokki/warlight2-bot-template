<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\GamePlay\PlaceMove;

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
	public function compute($ai, Environment $environment)
	{
		$moves = array();

		foreach( $ai->getPlaceMoves($environment) as $_move )
		{
			/** @var PlaceMove $_move */
			array_push($moves, $this->_moveToString($environment->getPlayer(), $_move));
		}
		
		return empty($moves) ? 'No moves' : implode(', ', $moves);
	}

	/**
	 * Returns the partial response string for a single place move.
	 *
	 * @param Player    $player the player performing the move
	 * @param PlaceMove $move   the move
	 *
	 * @return string
	 */
	protected function _moveToString(Player $player, PlaceMove $move)
	{
		return sprintf("%s place_armies %d %s", $player->getName(), $move->getDestinationRegionId(), $move->getArmies());
	}
}