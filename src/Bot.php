<?php

namespace Prokki\Warlight2BotTemplate\Util;

use Prokki\Warlight2BotTemplate\Command\ApplicableCommand;
use Prokki\Warlight2BotTemplate\Game\SetupMap;
use Prokki\Warlight2BotTemplate\GamePlay\AIable;
use Prokki\Warlight2BotTemplate\Command\Computable;
use Prokki\Warlight2BotTemplate\Game\Player;

define('PROKKIBOT_MAX_SERVER_TIMEOUT', 40); // [s]

/**
 * Class Client
 *
 * @package Prokki\Warlight2Bot
 *
 * @todo    Compability to vers. 1!
 * @todo    Comment all commands!
 * @todo    History / Moves / Map for each round ?
 * @todo    Extend Unittests!
 * @todo    implement opponent_moves?
 */
class Bot
{
	/**
	 * @var resource
	 */
	protected static $_DebugFileHandler = null;

	/**
	 * @var resource
	 */
	protected $_input = null;

	/**
	 * @var resource
	 */
	protected $_output = null;

	/**
	 * @var Parser
	 */
	protected $_parser = null;

	/**
	 * @var integer
	 */
	protected $_argc = 0;

	/**
	 * @var string[]
	 */
	protected $_argv = array();

	/**
	 * @var Player
	 */
	protected $_player = null;

	/**
	 * @var SetupMap
	 */
	protected $_map = null;

	/**
	 * @var AIable
	 */
	protected $_ai = null;

	/**
	 * @param string $string
	 *
	 * @author Falko Matthies <falko.ma@web.de>
	 */
	public static function Debug($string)
	{
		if( !is_resource(self::$_DebugFileHandler) )
		{
			return;
		}
		fwrite(self::$_DebugFileHandler, $string);
	}

	/**
	 * Warlight2Bot constructor.
	 *
	 * @param integer $argc
	 * @param string  $argv
	 * @param AIable  $ai
	 */
	public function __construct($argc, $argv, $ai)
	{
		$this->_parseCliArguments($argc, $argv);

		$this->_input  = fopen('php://stdin', 'r');
		$this->_output = fopen('php://stdout', 'w');

		$this->_parser = Parser::Init();

		$this->_player = new Player();
		$this->_map    = new SetupMap();
		$this->_ai     = $ai;
	}

	protected static function _Convert($size)
	{
		$unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
		return @round($size / pow(1024, ( $i = floor(log($size, 1024)) )), 2) . ' ' . $unit[ $i ];
	}

	/**
	 * Method is not testable (STDIN/STDOPUT problem),see http://stackoverflow.com/questions/15957533/how-test-stdin-in-phpunit or
	 * http://stackoverflow.com/questions/9158155/how-to-write-unit-tests-for-interactive-console-app
	 *
	 * @todo throw error one false!
	 *
	 */
	public function run()
	{
		// streams
		$read = [$this->_input];

		$write  = null;
		$except = null;

		// stream ends?
		$eof = false;

		do
		{

			$changed_streams = stream_select($read, $write, $except, PROKKIBOT_MAX_SERVER_TIMEOUT);

			if( false === $changed_streams )
			{
				die();
			}

			foreach( $read as $_handle )
			{

				$time_start = self::_GetMicrotimeFloat();

				$string = trim(fgets($_handle));

				if( empty($string) )
				{
					$eof = true;
					continue;
				}

				self::Debug(sprintf("received: %s\n", $string));

				$eof = feof($_handle);

				$command = $this->_parser->run($string);

//				self::Debug(get_class($command) . "\n");
				
				/** @var ApplicableCommand $command */
				$command->apply($this->_player, $this->_map);

				if( !$this->_map->isInitialized() && $this->_map->canBeInitialized() )
				{
					$this->_map->initialize();
				}

				if( $command->isSendable() )
				{
					/** @var Computable $command */
					$send = $command->compute($this->_ai, $this->_player);

					$duration = ( self::_GetMicrotimeFloat() - $time_start );
//					Client::Debug("TIME: " . $duration . "\n");

					if( $duration < 5000 )
					{
						usleep(5000 - $duration); // wait until at least 1ms are gone

//						$duration = ( self::_GetMicrotimeFloat() - $time_start );
//						Client::Debug("TIME: " . $duration . "\n");
					}

					fwrite($this->_output, $send . "\n");

					self::Debug(sprintf("send: %s\n", $send));
				}

			}
		}
		while( !$eof && !empty($changed_streams) );

		self::Debug("MEM: " . self::_Convert(memory_get_usage(true)) . "\n");

		self::Debug("END!\n");

		fclose($this->_input);


		if( is_resource(self::$_DebugFileHandler) )
		{
			fclose(self::$_DebugFileHandler);
		}

	}

	protected static function _GetMicrotimeFloat()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ( (float) $usec + (float) $sec );
	}

	/**
	 *
	 * @param integer $argc
	 * @param string  $argv
	 */
	protected function _parseCliArguments($argc, $argv)
	{
		$this->_parseCliArgumentHelp($argv);
		$this->_parseCliArgumentDebug($argv);
	}

	/**
	 *
	 * @param string $argv
	 */
	protected function _parseCliArgumentHelp($argv)
	{
		if( count(array_diff(['--help', '-h'], $argv)) < 2 )
		{
			$this->_exitWithUsage();
		}
	}

	/**
	 *
	 * @param string $argv
	 */
	protected function _parseCliArgumentDebug($argv)
	{
		if( count(array_diff(['--debug', '-d'], $argv)) < 2 )
		{

			$arg_debug_key = array_search('--debug', $argv);

			if( false === $arg_debug_key )
			{
				$arg_debug_key = array_search('-d', $argv);
			}

			if( !array_key_exists($arg_debug_key + 1, $argv) )
			{
				$this->_exitWithUsage();
			}

			$file = trim($argv[ $arg_debug_key + 1 ]);

			if( empty($file) )
			{
				$this->_exitWithUsage();
			}

			self::$_DebugFileHandler = fopen($file, 'w+');
		}
	}

	protected function _exitWithUsage()
	{
		printf("usage: php %s CLASS [--debug FILE]\n", basename(__FILE__));
		exit(0);
	}

}