<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot;
use Prokki\TheaigamesBotEngine\Command\ReceivableCommand;
use Prokki\Warlight2BotTemplate\Exception\ParserException;
use Prokki\Warlight2BotTemplate\Game\Move\PlaceMove;
use Prokki\Warlight2BotTemplate\Game\Move\TransferMove;
use Prokki\Warlight2BotTemplate\Game\RegionState;

/**
 * Class OpponentMovesCommand handles the information request with all visible opponent moves.
 *
 * Request: `opponent_moves [-m ...]` format differs by type of movement
 * - type _place_armies_: `opponent_moves [-b place_armies -i -i ...]` with player name, id of the destination region and amount of armies to place
 * - type _attack/transfer_: `opponent_moves [-b attack/transfer -i -i -i ...]` with player name, id of the source region, id of the destination region and amount of armies to attack/transfer
 *
 * Example:
 * ```
 * -> opponent_moves player2 place_armies 23 5 player2 attack/transfer 23 14 1 player2 attack/transfer 23 15 1
 * ```
 *
 * @package Prokki\Warlight2BotTemplate
 */
class OpponentMovesCommand extends ReceivableCommand
{
	/**
	 * all place moves, transfer AND attack moves
	 *
	 * The array holds no transfer move because a diffenrce between transfer and attack moves
	 * is right now possible in the {@see \Prokki\Warlight2BotTemplate\Command\OpponentMovesCommand::apply()} method.
	 *
	 * @var PlaceMove[]|TransferMove[]
	 */
	protected $_moves = array();

	/**
	 * @inheritdoc
	 */
	protected function _parseArguments($input, $arguments)
	{
		if( strlen($arguments) === 0 )
		{
			return;
		}

		$values = preg_split('/\s+/', $arguments);

		while( count($values) > 0 )
		{
			if( count($values) < 2 )
			{
				throw ParserException::CommandMissingArguments($input, 'Take a look to the documentation.');
			}

			switch( trim($values[ 1 ]) )
			{
				case 'place_armies':

					if( count($values) < 4 )
					{
						throw ParserException::CommandMissingArguments($input, 'Take a look to the documentation.');
					}

					array_push($this->_moves, new PlaceMove((int) $values[ 2 ], (int) $values[ 3 ]));


					array_splice($values, 0, 4);

					break;

				case 'attack/transfer':

					if( count($values) < 5 )
					{
						throw ParserException::CommandMissingArguments($input, 'Take a look to the documentation.');
					}

					array_push($this->_moves, new TransferMove((int) $values[ 2 ], (int) $values[ 3 ], (int) $values[ 4 ]));

					array_splice($values, 0, 5);

					break;

				default:
					var_dump("FEHLER!!!");
					var_dump($this->_moves);
					var_dump($this->_attack_transfer_moves);
					var_dump($values);
					die();
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		foreach( $this->_moves as $_move )
		{
			if( get_class($_move) === TransferMove::class
				&& $bot->getEnvironment()->getMap()->getRegion($_move->getDestinationRegionId())->getOwner() === RegionState::OWNER_ME
			)
			{
				$bot->getEnvironment()->getCurrentRound()->addOpponentMove($_move->toAttackMove());
			}
			else
			{
				$bot->getEnvironment()->getCurrentRound()->addOpponentMove($_move);
			}
		}
		
		$bot->getEnvironment()->addRound();
	}
}