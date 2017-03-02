<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\TheaigamesBotEngine\Command\ReceivableCommand;

/**
 * Class ListIntCommand to initialize the super regions.
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class ReceivableIntListCommand extends ReceivableCommand
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
		$this->_value = array_map('intval', preg_split('/\s+/', $arguments));

	}
}