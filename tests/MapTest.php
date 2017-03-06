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

	public function setUp()
	{
		$this->_map = new Map();

		$this->_map->addSuperRegionSetUp(1, 20);
		$this->_map->addSuperRegionSetUp(2, 19);
		$this->_map->addSuperRegionSetUp(3, 18);
		$this->_map->addSuperRegionSetUp(4, 17);

		$this->_map->addRegionSetUp(1, 2);
		$this->_map->addRegionSetUp(2, 4);
		$this->_map->addRegionSetUp(3, 1);
		$this->_map->addRegionSetUp(4, 2);
		$this->_map->addRegionSetUp(5, 3);
		$this->_map->addRegionSetUp(6, 3);
		$this->_map->addRegionSetUp(7, 4);
		$this->_map->addRegionSetUp(8, 3);
		$this->_map->addRegionSetUp(9, 4);

		$this->_map->addNeighborsSetUp(1, [4]);
		$this->_map->addNeighborsSetUp(2, [7]);
		$this->_map->addNeighborsSetUp(3, [4]);
		$this->_map->addNeighborsSetUp(4, [5, 8]);
		$this->_map->addNeighborsSetUp(5, [6, 8]);
		$this->_map->addNeighborsSetUp(6, [7, 8]);
		$this->_map->addNeighborsSetUp(7, [9]);
		$this->_map->addNeighborsSetUp(8, [9]);

		$this->_map->addWastelandSetUp(2);
		$this->_map->addWastelandSetUp(4);

		$this->_map->initialize();
	}

	public function tearDown()
	{
		$this->_map = null;
	}
}