<?php

namespace Prokki\Warlight2BotTemplate\Command;

/**
 *
 * @package Warlight2Bot\Command
 */
abstract class ReceivableStringCommand extends ReceivableCommand
{
	/**
	 * the value as integer
	 *
	 * @var string
	 */
	protected $_value = '';

	/**
	 * @inheritdoc
	 */
	protected function _parseArguments($input, $arguments)
	{
		$this->_value = $arguments;

	}
}