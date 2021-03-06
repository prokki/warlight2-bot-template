<?php

namespace Prokki\Warlight2BotTemplate;

use Prokki\TheaigamesBotEngine\Bot;
use Prokki\Warlight2BotTemplate\Command\Parser;
use Prokki\Warlight2BotTemplate\Game\Environment;
use Prokki\Warlight2BotTemplate\Game\EnvironmentFactory;

class AIBot implements Bot, AI
{
	/**
	 * @var Environment
	 */
	protected $_environment = null;

	/**
	 * @var EnvironmentFactory
	 */
	protected $_environmentFactory = null;

	/**
	 * @var Parser
	 */
	protected $_parser = null;

	/**
	 * AIBot constructor.
	 *
	 * Required: EnvironmentFactory must be initialized, see {@see \Prokki\Warlight2BotTemplate\Game\EnvironmentFactory::Init()}.
	 */
	public function __construct()
	{
		$this->_environment = EnvironmentFactory::Get()->newEnvironment();

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