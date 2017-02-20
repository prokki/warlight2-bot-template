<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\GamePlay\TransferMove;
use Prokki\Warlight2BotTemplate\Util\Client;

/**
 * Class GoAttackTransferCommand to initialize the super regions.
 *
 * See command `[-b attack/transfer -i -i -i] ...`
 *
 * @package Warlight2Bot\Command
 */
class GoAttackTransferCommand extends ReceivableIntCommand implements ApplicableCommand, SendableCommand
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

		foreach( $player->getAi()->getAttackTransferMoves($player) as $_move )
		{
			/** @var TransferMove $_move */
			array_push($moves, sprintf("%s attack/transfer %d %d %d",
				$player->getSetting()->getName(),
				$_move->getSourceRegionId(),
				$_move->getDestinationRegionId(),
				$_move->getArmies()
			));
		}

		return empty($moves) ? 'No moves' : implode(', ', $moves);
	}
}