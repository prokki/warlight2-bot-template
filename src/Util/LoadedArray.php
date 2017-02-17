<?php

namespace Prokki\Warlight2BotTemplate\Util;

class LoadedArray extends \ArrayObject
{
	use Loadable;

	/**
	 * @return mixed[]
	 */
	public function getOffsets()
	{
		return array_keys($this->getArrayCopy());
	}

	/**
	 *
	 * @author Falko Matthies <falko.m@web.de>
	 *
	 * @param callable $callable
	 *
	 * @return static
	 */
	public function filter($callable)
	{
		$filtered_object = new static();

		$offsets = $this->getOffsets();

		foreach( $offsets as $_offset )
		{
			$_object = $this->offsetGet($_offset);

			if( call_user_func($callable, $_object) )
			{
				$filtered_object->offsetSet($_offset, $_object);
			}
		}

		return $filtered_object;
	}
}