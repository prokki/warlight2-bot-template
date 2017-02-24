<?php

namespace Prokki\Warlight2BotTemplate\Command;

use Prokki\Warlight2BotTemplate\Game\Environment;

/**
 *
 * @package Prokki\Warlight2BotTemplate
 */
abstract class SetGlobalTimeComputableCommand extends ReceivableIntCommand implements Computable
{
	/**
	 * @inheritdoc
	 */
	public function apply(Environment $environment)
	{
		$environment->getPlayer()->setGlobalTime($this->_value);
	}

}