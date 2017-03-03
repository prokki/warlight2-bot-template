<?php

namespace Prokki\Warlight2BotTemplate\Test;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Game\EnvironmentFactory;
use Prokki\Warlight2BotTemplate\Game\Map;

abstract class MapTest extends TestCase
{
	/**
	 * ```
	 *        2           4
	 *        ┌───┐       ┌───┐       Y
	 *    1   │ 1 │   3   │#2#│       ┌─┐  Two regions included in one
	 *    ┌───┼   ┼───┬───┼   ┤       ├ ┤  super region (with id Y)
	 *    │ 3 │#4#│ 5   6 │ 7 │       └─┘
	 *    └───┼───┘   ┼   ┼   ┤
	 *        │     8     │ 9 │       #X# Wastelands
	 *        └───────────┴───┘
	 * ```
	 *
	 * @var Map
	 */
	protected $_map = null;

	public static function setUpBeforeClass()
	{
		EnvironmentFactory::Init();
	}

	public function setUp()
	{
		$this->_map = new Map();

		$this->_map->addSuperRegion(1, 20);
		$this->_map->addSuperRegion(2, 19);
		$this->_map->addSuperRegion(3, 18);
		$this->_map->addSuperRegion(4, 17);

		$this->_map->addRegion(1, 2);
		$this->_map->addRegion(2, 4);
		$this->_map->addRegion(3, 1);
		$this->_map->addRegion(4, 2);
		$this->_map->addRegion(5, 3);
		$this->_map->addRegion(6, 3);
		$this->_map->addRegion(7, 4);
		$this->_map->addRegion(8, 3);
		$this->_map->addRegion(9, 4);

		$this->_map->addNeighbors(1, [4]);
		$this->_map->addNeighbors(2, [7]);
		$this->_map->addNeighbors(3, [4]);
		$this->_map->addNeighbors(4, [5, 8]);
		$this->_map->addNeighbors(5, [6, 8]);
		$this->_map->addNeighbors(6, [7, 8]);
		$this->_map->addNeighbors(7, [9]);
		$this->_map->addNeighbors(8, [9]);

		$this->_map->addWasteland(2);
		$this->_map->addWasteland(4);

		$this->_map->initialize();
	}

	public function tearDown()
	{
		$this->_map = null;
	}
}