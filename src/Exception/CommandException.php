<?php

namespace Prokki\Warlight2BotTemplate\Exception;

class CommandException extends \Exception
{

	/**
	 * @param string $name the player's name
	 *
	 * @return CommandException
	 */
	public static function UnknownPlayerName($name)
	{
		return new self(sprintf("The name '%s' could not be assigned to any player.", $name), 105);
	}

	/**
	 * @param string $line
	 *
	 * @param string $hint [optional]
	 *
	 * @return CommandException
	 */
	public static function MissingArguments($line, $hint = '')
	{
		return new self(sprintf("Some arguments are missing for command \"%s\").%s",
			str_replace("\n", '', $line),
			empty($hint) ? '' : sprintf("\n%s", $hint)
		), 106);
	}

}