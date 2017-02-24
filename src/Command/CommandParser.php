<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Exception\ParserException;

/**
 * @link http://www.phptherightway.com/pages/Design-Patterns.html
 */
class CommandParser
{

	/**
	 * @var CommandParser
	 */
	private static $_Instance = null;

	/**
	 * @return CommandParser
	 */
	public static function Init()
	{
		if( is_null(self::$_Instance) )
		{
			self::$_Instance = new self();
		}

		return self::$_Instance;
	}

	protected function __construct() { }

	private function __clone() { }

	private function __wakeup() { }

	/**
	 * @param $string
	 *
	 * @return Command
	 *
	 * @throws ParserException
	 */
	public function run($string)
	{
		$matches = array();

		if( 1 === preg_match('/^\s*settings.*$/si', $string) )
		{
			return $this->_parseSettingsCommand($string);
		}
		elseif( 1 === preg_match('/^\s*setup_map.*$/si', $string) )
		{
			return $this->_parseSetupMapCommand($string);
		}
		elseif( 1 === preg_match('/^\s*(pick_starting_region)|(go\s+place_armies)|(go\s+attack\/transfer)\s*(.*)$/si', $string) )
		{
			return $this->_parseSendableCommand($string);
		}
		elseif( 1 === preg_match('/^\s*update_map\s*(.*)$/si', $string, $matches) )
		{
			return new UpdateMapCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*opponent_moves\s*(.*)$/si', $string, $matches) )
		{
			return new OpponentMovesCommand($matches[ 0 ], trim($matches[ 1 ]));
		}

		if( 1 === preg_match('/^([^\s]+)/si', $string, $matches) )
		{
			throw ParserException::CommandUnknown($matches[ 0 ]);
		}
		else
		{
			throw ParserException::CommandLineNotParseable($string);
		}
	}

	/**
	 * @param $string
	 *
	 * @return Command
	 *
	 * @throws ParserException
	 */
	protected function _parseSettingsCommand($string)
	{
		$matches = array();

		if( 1 === preg_match('/^\s*settings\s+your_bot\s+(.*)$/si', $string, $matches) )
		{
			return new SettingsYourBotCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*settings\s+opponent_bot\s+(.*)$/si', $string, $matches) )
		{
			return new SettingsOpponentBotCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*settings\s+timebank\s+(.*)$/si', $string, $matches) )
		{
			return new SettingsTimebankCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*settings\s+starting_armies\s+(.*)$/si', $string, $matches) )
		{
			return new SettingsStartingArmiesCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*settings\s+time_per_move\s+(.*)$/si', $string, $matches) )
		{
			return new SettingsTimePerMoveCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*settings\s+max_rounds\s+(.*)$/si', $string, $matches) )
		{
			return new SettingsMaxRoundsCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*settings\s+starting_pick_amount\s+(.*)$/si', $string, $matches) )
		{
			return new SettingsStartingPickAmountCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*settings\s+starting_regions\s+(.*)$/si', $string, $matches) )
		{
			return new SettingsStartingRegionsCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		else
		{
			throw ParserException::CommandIncomplete($string);
		}
	}

	/**
	 * @param $string
	 *
	 * @return Command
	 *
	 * @throws ParserException
	 */
	protected function _parseSetupMapCommand($string)
	{
		$matches = array();

		if( 1 === preg_match('/^\s*setup_map\s+super_regions\s+(.*)$/si', $string, $matches) )
		{
			return new SetupMapSuperRegionsCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*setup_map\s+regions\s+(.*)$/si', $string, $matches) )
		{
			return new SetupMapRegionsCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*setup_map\s+neighbors\s+(.*)$/si', $string, $matches) )
		{
			return new SetupMapNeighborsCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*setup_map\s+wastelands\s+(.*)$/si', $string, $matches) )
		{
			return new SetupMapWastelandsCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*setup_map\s+opponent_starting_regions\s+(.*)$/si', $string, $matches) )
		{
			return new SetupMapOpponentStartingRegionsCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		else
		{
			throw ParserException::CommandIncomplete($string);
		}
	}

	/**
	 * @param $string
	 *
	 * @return Command
	 *
	 * @throws ParserException
	 */
	protected function _parseSendableCommand($string)
	{
		$matches = array();

		if( 1 === preg_match('/^\s*pick_starting_region\s*(.*)$/si', $string, $matches) )
		{
			return new PickStartingRegionCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*go\s+place_armies\s*(.*)$/si', $string, $matches) )
		{
			return new GoPlaceArmiesCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		elseif( 1 === preg_match('/^\s*go\s+attack\/transfer\s*(.*)$/si', $string, $matches) )
		{
			return new GoAttackTransferCommand($matches[ 0 ], trim($matches[ 1 ]));
		}
		else
		{
			throw ParserException::CommandIncomplete($string);
		}
	}
}