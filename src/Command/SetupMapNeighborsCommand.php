<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Bot;
use Prokki\TheaigamesBotEngine\Command\ReceivableCommand;
use Prokki\Warlight2BotTemplate\Exception\ParserException;

/**
 * Class SettingsTimebankCommand to set/get the timebank of your bot.
 *
 * @package Prokki\Warlight2BotTemplate
 */
class SetupMapNeighborsCommand extends ReceivableCommand
{

	/**
	 * the neighbors as associative array: the key is a region id, the value is an array of connected region ids.
	 *
	 * @var integer[]
	 */
	protected $_neighbors = array();

	/**
	 * @inheritdoc
	 */
	protected function _parseArguments($input, $arguments)
	{
		// remove whitespaces between colons
		$edited_arguments = preg_replace('/\s*,\s*/si', ',', $arguments);

		$numbers = preg_split('/\s+/', $edited_arguments);

		if( 0 !== count($numbers) % 2 )
		{
			throw ParserException::CommandMissingArguments($input, "The amount of arguments must be even.");
		}

		for( $_i = 0; $_i < count($numbers); $_i = $_i + 2 )
		{
			$_region_id  = (int) $numbers[ $_i ];
			$_region_ids = array_map('intval', explode(',', $numbers[ $_i + 1 ]));

			$this->_neighbors[ $_region_id ] = $_region_ids;
		}

	}

	/**
	 * @inheritdoc
	 */
	public function apply(Bot $bot)
	{
		foreach( $this->_neighbors as $_region_id => $_region_ids )
		{
			$bot->getEnvironment()->getMap()->addNeighborsSetUp($_region_id, $_region_ids);
		}

		if( $bot->getEnvironment()->getMap()->finishAddingNeighbors() )
		{
			$bot->getEnvironment()->getCurrentRound()->setInitialMap(clone $bot->getEnvironment()->getMap());
		}
	}

}