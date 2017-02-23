<?php

namespace Prokki\Warlight2BotTemplate\Util;

interface Initializeable
{
	/**
	 * @return boolean
	 */
	public function isInitialized();

	/**
	 * @return boolean
	 */
	public function initialize();

	/**
	 * @return boolean
	 */
	public function canBeInitialized();
}