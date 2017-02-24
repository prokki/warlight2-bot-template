## Changes in Warlight2BotTemplate

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project Warlight2BotTemplate to [Semantic Versioning](http://semver.org/).

### [Unreleased]
#### Fixed
- Commands `opponent_moves`, [GoPlaceArmiesCommand](src/Command/GoPlaceArmiesCommand.php) and [GoAttackTransferCommand](src/Command/GoAttackTransferCommand.php) fixed.
- Fixed some command class names.
- Fixed `composer.json`: set _type_ to `library`, added directory `tests` to section _autoload_.
#### Changed
- Massively reorganized namespace structure.
- Divided game class "tank" in classes [Bot](src/Bot.php), [Player](src/Game/Player.php) and [Map](src/Game/Map.php).
- Changed class [Map](src/Game/Map.php) to save _snapshots_ for rounds - changed whole object initialization process.
- Moved map initialization to class [SetupMap](src/Game/SetupMap.php).
#### Added
- Added class [Round](src/Game/Round.php) to save map snapshots and player moves of each round.
- Added class [Environment](src/Game/Environment.php) as container for player, map and rounds.
- Added [CHANGELOG.md](CHANGELOG.md) file.
- Ignored `composer.lock` by git.
- Added configuration file and `@covers` annotations for code coverage.
- Interface [Move](src/Game/Move/Move) and move [PickMove](src/Game/Move/PickMove) added.
- Added missing unit test for command classes.
 
### [0.0.1] - 2017-02-17
#### Added
- First (unusable) version
- First UnitTests