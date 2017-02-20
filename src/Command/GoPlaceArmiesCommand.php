<?php

namespace Prokki\Warlight2BotTemplate\Command;

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
 * ```go place_armies 10000
 * player1 place_armies 1 2, player1 place_armies 2 5```
 *
 * @package Prokki\Warlight2BotTemplate
 *          
 * @todo test is missing
 */
class GoPlaceArmiesCommand extends ReceivableIntCommand implements ApplicableCommand, SendableCommand
{


	/**
	 * @inheritdoc
	 */
	public function apply($player)
	{
		$player->setGlobalTime($this->_value);
	}

	/**
	 * @inheritdoc
	 */
	public function compute($player)
	{
		$moves = array();

		foreach( $player->getAi()->getPlaceMoves($player) as $_move )
		{
			/** @var PlaceMove $_move */
			array_push($moves, sprintf("%s place_armies %d %s",
				$player->getSetting()->getName(),
				$_move->getDestinationRegionId(),
				$_move->getArmies()
			));
		}

		return empty($moves) ? 'No moves' : implode(', ', $moves);
	}
}