<?php

namespace Prokki\Warlight2BotTemplate\Command;

/**
 * Class ListIntCommand to initialize the super regions.
 *
 * @package Warlight2Bot\Command
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