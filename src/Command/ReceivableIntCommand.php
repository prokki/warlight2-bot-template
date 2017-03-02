<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Command\ReceivableCommand;
use Prokki\Warlight2BotTemplate\Exception\ParserException;

/**
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class ReceivableIntCommand extends ReceivableCommand
{
	/**
	 * the value as integer
	 *
	 * @var integer
	 */
	protected $_value = 0;

	/**
	 * @inheritdoc
	 */
	protected function _parseArguments($input, $arguments)
	{
		if( empty($arguments) )
		{
			throw ParserException::CommandMissingArguments($input);
		}
		
		$this->_value = (int) $arguments;
	}
}