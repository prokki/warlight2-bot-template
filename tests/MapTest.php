<?php

namespace Prokki\Warlight2BotTemplate\Test;

use PHPUnit\Framework\TestCase;
use Prokki\Warlight2BotTemplate\Game\EnvironmentFactory;
use Prokki\Warlight2BotTemplate\Game\Map;

abstract class MapTest extends TestCase
{
	/**
	 * ```
	 *        2(12)       4(4)
	 *        ┌───┐       ┌───┐       Y(BONUS)
	 *   1(20)│ 1 │ 3(18) │#2#│       ┌─┐  Two regions included in one
	 *    ┌───┼   ┼───┬───┼   ┤       ├ ┤  super region (with id Y and an
	 *    │ 3 │#4#│ 5   6 │ 7 │       └─┘  amount of BONUS bonus armies)
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
		$_map = new Map();

		$_map->addSuperRegionSetUp(1, 20);
		$_map->addSuperRegionSetUp(2, 12);
		$_map->addSuperRegionSetUp(3, 18);
		$_map->addSuperRegionSetUp(4, 4);

		$_map->addRegionSetUp(1, 2);
		$_map->addRegionSetUp(2, 4);
		$_map->addRegionSetUp(3, 1);
		$_map->addRegionSetUp(4, 2);
		$_map->addRegionSetUp(5, 3);
		$_map->addRegionSetUp(6, 3);
		$_map->addRegionSetUp(7, 4);
		$_map->addRegionSetUp(8, 3);
		$_map->addRegionSetUp(9, 4);

		$_map->addNeighborsSetUp(1, [4]);
		$_map->addNeighborsSetUp(2, [7]);
		$_map->addNeighborsSetUp(3, [4]);
		$_map->addNeighborsSetUp(4, [5, 8]);
		$_map->addNeighborsSetUp(5, [6, 8]);
		$_map->addNeighborsSetUp(6, [7, 8]);
		$_map->addNeighborsSetUp(7, [9]);
		$_map->addNeighborsSetUp(8, [9]);

		$_map->addWastelandSetUp(2);
		$_map->addWastelandSetUp(4);

		$this->_map = clone $_map;
	}

	public function tearDown()
	{
		$_map = null;
	}
}