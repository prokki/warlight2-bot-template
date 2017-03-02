<?php

namespace Prokki\Warlight2BotTemplate\Bot;

use Prokki\TheaigamesBotEngine\Bot\Bot;
use Prokki\Warlight2BotTemplate\Command\Parser;
use Prokki\Warlight2BotTemplate\Game\Environment;

class AIBot implements Bot, AI
{
	/**
	 * @var Environment
	 */
	protected $_environment = null;

	/**
	 * @var Parser
	 */
	protected $_parser = null;

	public function __construct()
	{
		$this->_environment = new Environment();

		$this->_parser = new Parser();
	}

	/**
	 * @return \Prokki\TheaigamesBotEngine\Game\Environment
	 */
	public function getEnvironment()
	{
		return $this->_environment;
	}

	/**
	 * @return Parser
	 */
	public function getParser()
	{
		return $this->_parser;
	}

	/**
	 * @inheritdoc
	 */
	public function getPickMove($region_ids)
	{
		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function getAttackTransferMoves()
	{
		return array();
	}

	/**
	 * @inheritdoc
	 */
	public function getPlaceMoves()
	{
		return array();
	}
}