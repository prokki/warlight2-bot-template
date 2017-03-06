<?php

namespace Prokki\Warlight2BotTemplate\Examples\StupidRandomBot;

use Prokki\Warlight2BotTemplate\AIBot;
use Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\Game\EnvironmentFactory;
use Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\Game\RegionState;
use Prokki\Warlight2BotTemplate\Game\Move\AttackMove;
use Prokki\Warlight2BotTemplate\Game\Move\PickMove;
use Prokki\Warlight2BotTemplate\Game\Move\PlaceMove;
use Prokki\Warlight2BotTemplate\Game\Move\TransferMove;
use Prokki\Warlight2BotTemplate\Game\Region;
use Prokki\Warlight2BotTemplate\Game\RegionArray;

/**
 * StupidRandomBot is a simple bot used to describe how to use the Warlight2BotTemplate.
 *
 * @package Prokki\Warlight2BotTemplate\StupidRandomBot
 */
class StupidRandomBot extends AIBot
{

	/**
	 * The constructor of your bot is not necessary, but advisable.
	 *
	 * Especially if you your bot uses overridden classes you have to *initialize
	 * your custom `EnvironmentFactory`*.
	 *
	 * @inheritdoc
	 */
	public function __construct($init_inventory = true)
	{
		if( $init_inventory )
		{
			EnvironmentFactory::Init();
		}

		parent::__construct();
	}

	/**
	 * @inheritdoc
	 */
	public function getPickMove($region_ids)
	{
		mt_srand((double) microtime() * 1234567);
		$index = mt_rand(0, count($region_ids) - 1);

		$region = $this->_environment->getMap()->getRegion($region_ids[ $index ]);

		$region->»getState()->setOwner(RegionState::OWNER_ME);

		return new PickMove($region->getId());
	}

	protected static function _ChooseIndexes($length)
	{
		if( $length < 1 )
		{
			return array();
		}

		mt_srand((double) microtime() * 9876543);

		$moves = mt_rand(
			max(1, floor(log($length, M_E))),
			max(1, ceil(log($length, 2)))
		);

		$moves = min($moves, $length);

		$chosen_indexes = array();

		do
		{
			do
			{
				$_chosen_index = rand(0, $length - 1);
			}
			while( in_array($_chosen_index, $chosen_indexes) );

			array_push($chosen_indexes, $_chosen_index);
		}
		while( count($chosen_indexes) < $moves );

		return $chosen_indexes;
	}

	/**
	 * @inheritdoc
	 */
	public function getAttackTransferMoves()
	{
		$source_regions = $this->_environment->getMap()->getRegions()->filterOwner(RegionState::OWNER_ME);

		$chosen_source_seq = self::_ChooseIndexes(count($source_regions));

		$seq_region = 0;

		$moves = array();

		foreach( $source_regions as $_source_region )
		{

			/** @var Region $_source_region */
			if( $_source_region->getArmies() <= 1 || !in_array($seq_region, $chosen_source_seq) )
			{
				++$seq_region;

				continue;
			}

			/** @var RegionArray $_destination_regions */
			$_destination_regions = $_source_region->getNeighbors();

			$_chosen_destination_seq = self::_ChooseIndexes(count($_destination_regions));

			$_seq_destination = 0;

			foreach( $_destination_regions as $__destination_region )
			{
				/** @var Region $__destination_region */
				if( !in_array($_seq_destination, $_chosen_destination_seq) )
				{
					continue;
				}

				array_push($moves, ( $__destination_region->getOwner() === RegionState::OWNER_ME ) ?
					new TransferMove($_source_region->getId(), $__destination_region->getId(), $_source_region->getArmies() - 1) :
					new AttackMove($_source_region->getId(), $__destination_region->getId(), $_source_region->getArmies() - 1)
				);

				++$_seq_destination;
			}

			++$seq_region;
		}

		return $moves;
	}

	/**
	 * @inheritdoc
	 */
	public function getPlaceMoves()
	{
		mt_srand((double) microtime() * 10101010);

		$armies_to_dispense = $this->_environment->getPlayer()->getStartingArmies();

		$my_region_ids = $this->_environment->getMap()->getRegions()->filterOwner(RegionState::OWNER_ME)->getIds();

		$armies_to_place = array();

		$circa_placements = min(count($my_region_ids), rand(1, ceil(log($armies_to_dispense, 1.75))));

		$placement_round_no = 1;

		do
		{
			$_already_placed_armies = array_sum($armies_to_place);

			$_max_armies_to_place_this_round = $armies_to_dispense - $_already_placed_armies;

			$_armies_this_round = rand(1, $_max_armies_to_place_this_round - $circa_placements + $placement_round_no);

			array_push($armies_to_place, $_armies_this_round);

			++$placement_round_no;
		}
		while( array_sum($armies_to_place) < $armies_to_dispense );

		$moves = array();

		foreach( $armies_to_place as $_armies )
		{
			shuffle($my_region_ids);

			array_push($moves, new PlaceMove(array_pop($my_region_ids), $_armies));
		}

		return $moves;
	}
}