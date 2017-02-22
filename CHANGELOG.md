## Changes in Warlight2BotTemplate

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project Warlight2BotTemplate to [Semantic Versioning](http://semver.org/).

### [Unreleased]
#### Fixed
 - commands `opponent_moves`, `go place_armies` and `go attack/transfer` fixed
 - fixed some command class names
 - `composer.json`: set _type_ to `library`, added directory `tests` to section _autoload_
#### Changed
 - divided `Player`, `Map` and `Bot` class
 - reorganized namespace structure
#### Added
 - added CHANGELOG file
 - ignore `composer.lock` by git
 - add configuration file and `@covers` annotations for code coverage
 - added missing unit test for command classes
 
### [0.0.1] - 2017-02-17
#### Added
 - first (unusable) version
 - first UnitTests