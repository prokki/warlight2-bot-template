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
		return new self(sprintf("The region with ID %d is not known.", $id), 301);
	}

	/**
	 * @param integer $id the id of the unknown super region
	 *
	 * @return RuntimeException
	 */
	public static function UnknownSuperRegion($id)
	{
		return new self(sprintf("The super region with ID %d is not known.", $id), 311);
	}
}