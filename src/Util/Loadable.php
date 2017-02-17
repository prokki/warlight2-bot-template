<?php

namespace Prokki\Warlight2BotTemplate\Util;

trait Loadable
{
	/**
	 * @var boolean
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	protected $_loaded = false;

	/**
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function setLoaded()
	{
		$this->_loaded = true;
	}

	/**
	 * @return boolean
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 */
	public function isLoaded()
	{
		return $this->_loaded;
	}
}