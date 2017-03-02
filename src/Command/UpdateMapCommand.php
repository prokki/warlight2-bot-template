<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot\Bot;
use Prokki\TheaigamesBotEngine\Command\ReceivableCommand;
use Prokki\Warlight2BotTemplate\Exception\ParserException;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionState;

/**
 * Class UpdateMapCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class UpdateMapCommand extends ReceivableCommand
{
	/**
	 * the value associative array: the even argument is the key, the odd one the value
	 *
	 * @var (mixed[])[]
	 */
	protected $_updates = array();

	/**
	 * Returns the region owner as constant (integer) by the given player's name.
	 *
	 * @param string $name   the player name to convert (i.e. `player1`, `player2`, `neutral`)
	 * @param Player $player the player object to execute comparision of player names
	 *
	 * @return integer
	 *
	 * @throws ParserException
	 */
	protected static function _GetRegionOwnerByPlayerName($name, $player)
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
	 * @inheritdoc
	 */
	protected function _parseArguments($input, $arguments)
	{
		$args = preg_split('/\s+/', $arguments);

		if( 0 !== count($args) % 3 )
		{
			throw ParserException::CommandMissingArguments($input, "The amount of arguments must be dividable by three.");
		}

		for( $_i = 0; $_i < count($args); $_i = $_i + 3 )
		{
			$_region_id   = (int) $args[ $_i ];
			$_player_name = trim($args[ $_i + 1 ]);
			$_armies      = (int) $args[ $_i + 2 ];

			if( !array_key_exists($_player_name, $this->_updates) )
			{
				$this->_updates[ $_region_id ] = array(
					'player_name' => $_player_name,
					'armies'      => $_armies,
				);
			}
		}

	}

	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		foreach( $this->_updates as $_player_name => $_regions )
		{
			foreach( $bot->getEnvironment()->getMap()->getRegions() as $__region_id => $__region )
			{
				/** @var Region $region */

				if( array_key_exists($__region_id, $this->_updates) )
				{
					$__region_owner = self::_GetRegionOwnerByPlayerName($this->_updates[ $__region_id ][ 'player_name' ], $bot->getEnvironment()->getPlayer());

					/** @var Region $__region */
					$__region->disableFog($this->_updates[ $__region_id ][ 'armies' ], $__region_owner);
				}
				else
				{
					$__region->enableFog();
				}
			}
		}
	}
}