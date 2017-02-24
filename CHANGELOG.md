## Changes in Warlight2BotTemplate

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project Warlight2BotTemplate to [Semantic Versioning](http://semver.org/).

### [Unreleased]
#### Fixed
- Commands `opponent_moves`, `go place_armies` and `go attack/transfer` fixed
- Fixed some command class names
- `composer.json`: set _type_ to `library`, added directory `tests` to section _autoload_
#### Changed
- Divided `Player`, `Map` and `Bot` class
- Reorganized namespace structure
- Changed class `Map` to save _snapshots_ for rounds - changed whole object initialization process
- Moved map initialization to class `SetupMap`
#### Added
- Classes `Round` to save map snapshots and player moves of each round
- Added class Environment as container for player, map and rounds
- Added CHANGELOG file
- Ignore `composer.lock` by git
- Add configuration file and `@covers` annotations for code coverage
- Added missing unit test for command classes
 
### [0.0.1] - 2017-02-17
#### Added
- First (unusable) version
- First UnitTests