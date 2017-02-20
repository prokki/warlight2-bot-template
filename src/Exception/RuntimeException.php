<?php

namespace Prokki\Warlight2BotTemplate\Exception;

/**
 * Class RuntimeException
 *
 * @package Prokki\Warlight2BotTemplate
 */
class RuntimeException extends \Exception
{
	/**
	 * @param integer $id the id of the unknown region
	 *
	 * @return RuntimeException
	 */
	public static function UnknownRegion($id)
	{
		return new self(sprintf("The region (ID %d) is not known.", $id), 301);
	}
}