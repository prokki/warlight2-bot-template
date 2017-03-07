## Changes in Warlight2BotTemplate

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project Warlight2BotTemplate to [Semantic Versioning](http://semver.org/).

### [Unreleased]

### [0.3.0] - 2017-03-06

#### Added
* Continued to complete unit tests.

#### Changed
* new namespaces for examples [Prokki\Warlight2BotTemplate\Examples](examples/).
* [StupidRandomBot.php](examples/StupidRandomBot/src/StupidRandomBot.php) moved to example directory.
* Base classes for bots moved to root directory [/src](src/).
* Added getter and setter to [RegionArray](src/Game/RegionArray.php) and [SuperRegionArray](src/Game/SuperRegionArray.php) to abstract ArrayObject
(avoid using `offset*()` methods) 

### [0.2.0] - 2017-03-03

#### Added
* Adapted classes to use environmental factory classes [EnvironmentFactory](src/Game/EnvironmentFactory.php).
* Added class [SuperRegionArray](src/Game/SuperRegionArray.php) to differentiate to [RegionArray](src/Game/RegionArray.php).
* Constant `RegionState::OWNER_ALL` added.

#### Fixed
* All super regions will be initialized with references to assigned regions.
* Removed some type hints to allow overriding of template classes.
    
#### Changed
* Bot engine outsourced to https://github.com/prokki/theaigames-bot-engine.
* Commands updated to use Bot instead of `AIable` (and [Environment](src/Game/Environment.php))
* Renamed class AI to [AIBot.php](src/AIBot.php), class RandomBot to [StupidRandomBot.php](examples/StupidRandomBot/src/StupidRandomBot.php)
* Method `RegionArray::getOffsets()` does not use `getArrayCopy()` anymore.
* Method to filter regions by owner moved from [Map](src/Game/Map.php) (method `getRegions()`).
to [RegionArray](src/Game/RegionArray.php).


### [0.1.2] - 2017-03-02

#### Changed

* Bot engine outsourced to [https://github.com/prokki/theaigames-bot-engine](https://github.com/prokki/theaigames-bot-engine).

### [0.1.1] - 2017-02-27

#### Fixed

* fixed [CHANGELOG.md](CHANGELOG.md)

### [0.1.0] - 2017-02-27

#### Fixed

* Commands [GoPlaceArmiesCommand](src/Command/GoPlaceArmiesCommand.php) and [GoAttackTransferCommand](src/Command/GoAttackTransferCommand.php) fixed.
* Fixed some command class names.
* Fixed `composer.json`: set _type_ to `library`, added directory `tests` to section _autoload_.

#### Changed

* Massively reorganized namespace structure.
* Divided game class "tank" in classes [Bot](src/Bot.php), [Player](src/Game/Player.php) and [Map](src/Game/Map.php).
* Changed class [Map](src/Game/Map.php) to save _snapshots_ for rounds - changed whole object initialization process.
* Moved map initialization to class [SetupMap](src/Game/SetupMap.php).

#### Added

*- Interface [Move](src/Game/Move/Move) and move [PickMove](src/Game/Move/PickMove) added.
* Added class [Round](src/Game/Round.php) to save map snapshots and player moves of each round.
*- Added class [Environment](src/Game/Environment.php) as container for player, map and rounds.
*- Added missing command [OpponentMovesCommand](src/Command/OpponentMovesCommand.php).
*- Added configuration file and `@covers` annotations for code coverage.
*- Added missing unit test for command classes.
*- Added [CHANGELOG.md](CHANGELOG.md) file.
*- Ignored `composer.lock` by git.
 
### [0.0.1] - 2017-02-17

#### Added

*- First (unusable) version
*- First UnitTests