<?php

namespace Prokki\Warlight2BotTemplate\Util;

trait Initializeable
{

	/**
	 * @var boolean
	 */
	protected $_initialized = false;

	/**
	 *
	 */
	public function setInitialized()
	{
		$this->_initialized = true;
	}

	/**
	 * @return boolean
	 *
	 */
	public function isInitialized()
	{
		return $this->_initialized;
	}
}