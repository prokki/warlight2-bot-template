<?php

namespace Prokki\Warlight2BotTemplate\Command;

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
		$this->_value = (int) $arguments;

	}
}