<?php

namespace Prokki\Warlight2BotTemplate\Util\ArrayObject;

trait Loadable
{
	/**
	 * @var boolean
	 *
	 */
	protected $_loaded = false;

	/**
	 *
	 */
	public function setLoaded()
	{
		$this->_loaded = true;
	}

	/**
	 * @return boolean
	 *
	 */
	public function isLoaded()
	{
		return $this->_loaded;
	}
}