<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Exception\ParserException;

/**
 * Class IntTupelCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class ReceivableTupleIntListCommand extends ReceivableCommand
{
	/**
	 * the value associative array: the even argument is the key, the odd one the value
	 *
	 * @var integer[]
	 */
	protected $_value = array();

	/**
	 * @inheritdoc
	 */
	protected function _parseArguments($input, $arguments)
	{
		$numbers = preg_split('/\s+/', $arguments);

		if( 0 !== count($numbers) % 2 )
		{
			throw ParserException::CommandMissingArguments($input, "The amount of arguments must be even.");
		}

		for( $_i = 0; $_i < count($numbers); $_i = $_i + 2 )
		{
			$_key   = (int) $numbers[ $_i ];
			$_value = (int) $numbers[ $_i + 1 ];

			$this->_value[ $_key ] = $_value;
		}

	}
}