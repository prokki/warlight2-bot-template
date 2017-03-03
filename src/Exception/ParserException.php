<?php

namespace Prokki\Warlight2BotTemplate\Exception;

class ParserException extends \Exception
{

	/**
	 * @param string $name the player's name
	 *
	 * @return ParserException
	 */
	public static function UnknownPlayerName($name)
	{
		return new self(sprintf("The name '%s' could not be assigned to any player.", $name), 105);
	}
}