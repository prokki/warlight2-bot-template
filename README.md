## Warlight2BotTemplate

[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](https://github.com/prokki/warlight2-bot/blob/master/LICENSE)
[![Packagist](https://img.shields.io/badge/Packagist-0.1.1-blue.svg?style=flat)](https://packagist.org/packages/prokki/warlight2-bot-template)
[![Minimum PHP Version](https://img.shields.io/badge/PHP-%3D5.6.13-8892BF.svg)](https://php.net/)

This is a php bot template for Warlight AI Challenge 2 (http://theaigames.com/competitions/warlight-ai-challenge-2). 

> Note: The project is in beta stage. Feel free to report any issues you encounter.

### Installation

#### Composer

Create a new project and install the template via Composer using the following command:

    composer require prokki/warlight2-bot-template

### Basic Usage

#### Create Your Own Bot

Create your own bot by inherit from the [Prokki\Warlight2BotTemplate\Bot\AIBot](src/Bot/AIBot.php) class.
To ensure the bot is responding correctly the [Prokki\Warlight2BotTemplate\Bot\AIBot](src/Bot/AIBot.php)
implements the interface [Prokki\Warlight2BotTemplate\Bot\AI](src/Bot/AI.php). Following methods has t be
overridden:
```php
class YOUR_AI implements Prokki\Warlight2BotTemplate\GamePlay\AIable
{
    /**
     * Returns the pick move of the region to pick.
     *
     * These moves are going to build the response to the request `pick_starting_region` - see {@see \Prokki\Warlight2BotTemplate\Command\PickStartingRegionCommand}.
     *
     * @param integer[] $region_ids
     *
     * @return PickMove|null
     */
    public function getPickMove($region_ids)
    {
        // put your code here
    }

    /**
     * Returns all place moves.
     *
     * These moves are going to build the response to the request `go place_armies` - see {@see \Prokki\Warlight2BotTemplate\Command\GoPlaceArmiesCommand}.
     *
     * @return PlaceMove[]
     */
    public function getPlaceMoves();
    {
        // put your code here
    }

    /**
     * Returns all attack and transfer moves.
     *
     * These moves are going to build the response to the request `go attack/transfer` - see {@see \Prokki\Warlight2BotTemplate\Command\GoAttackTransferCommand}.
     *
     * @return TransferMove[]|AttackMove[]
     */
    public function getAttackTransferMoves();
    {
        // put your code here
    }
}
```

#### Example

Take a look to example class [Prokki\Warlight2BotTemplate\Bot\StupidRandomBot](src/Bot/StupidRandomBot.php) for further information.

### Links
* Game challenge page: http://theaigames.com/competitions/warlight-ai-challenge-2
* Game source: https://github.com/theaigames/warlight2-engine
* Game viewer to visualize/play a (compatible) game: https://github.com/kefik/conquest-engine-gui
