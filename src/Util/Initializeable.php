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
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setInitialized()
	{
		$this->_initialized = true;
	}

	/**
	 * @return boolean
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function isInitialized()
	{
		return $this->_initialized;
	}
}