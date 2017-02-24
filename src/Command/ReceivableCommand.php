<?php

namespace Prokki\Warlight2BotTemplate\Command;

/**
 * Class ReceivableCommand
 *
 * @package Prokki\Warlight2BotTemplate\Command
 */
abstract class ReceivableCommand extends Command
{

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