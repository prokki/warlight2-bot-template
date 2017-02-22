<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Exception\ParserException;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\RegionState;

/**
 * Class ReceivableCommand
 *
 * @package Prokki\Warlight2BotTemplate\Command
 */
abstract class ReceivableCommand extends Command
{

	/**
	 * Returns the region owner by the given player's name.
	 *
	 * @param Player $player
	 * @param string $name
	 *
	 * @return int
	 * @throws ParserException
	 */
	protected static function _GetRegionOwnerByPlayerName($player, $name)
	{
		switch( $name )
		{
			case 'neutral':
				return RegionState::OWNER_NEUTRAL;
			case $player->getName():
				return RegionState::OWNER_ME;
			case $player->getNameOpponent():
				return RegionState::OWNER_OPPONENT;
			default:
				throw ParserException::UnknownPlayerName($name);
		}
	}

	/**
	 * @param string $command   complete command line
	 * @param string $arguments only the arguments as string (already included in the `$input`)
	 *
	 */
	public function __construct($command, $arguments)
	{
		$this->_parseArguments($command, $arguments);
	}

	/**
	 * @param string $input     complete command line
	 * @param string $arguments only the arguments as string (already included in the `$input`)
	 *
	 * @return Command
	 *
	 */
	abstract protected function _parseArguments($input, $arguments);
}