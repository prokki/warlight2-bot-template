<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Command\ReceivableCommand;

/**
 *
 * @package Prokki\Warlight2BotTemplate
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