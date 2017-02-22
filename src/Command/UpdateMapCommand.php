<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Exception\ParserException;
use Prokki\Warlight2BotTemplate\Game\Player;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\SetupMap;

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
	public function apply(Player $player, SetupMap $map)
	{
		foreach( $this->_updates as $_player_name => $_regions )
		{
			foreach( $map->getRegions() as $__region_id => $__region )
			{
				/** @var Region $region */

				if( array_key_exists($__region_id, $this->_updates) )
				{
					$__region_owner = self::_GetRegionOwnerByPlayerName($player, $this->_updates[ $__region_id ][ 'player_name' ]);

					$__region->getState()->disableFog($this->_updates[ $__region_id ][ 'armies' ], $__region_owner);
				}
				else
				{
					$__region->getState()->enableFog();
				}
			}
		}
	}
}