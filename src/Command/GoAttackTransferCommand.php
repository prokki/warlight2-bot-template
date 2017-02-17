<?php

namespace Prokki\Warlight2BotTemplate\Command;

/**
 * Class GoAttackTransferCommand to initialize the super regions.
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
	public function compute($ai, $player)
	{
		return sprintf("%s attack/transfer %s", $player->getSetting()->getName(), implode($ai->getAttackTransferMoves($player)));
	}
}