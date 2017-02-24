## Warlight2BotTemplate

[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](https://github.com/prokki/warlight2-bot/blob/master/LICENSE)
[![Packagist](https://img.shields.io/badge/Packagist-0.0.1-blue.svg?style=flat)](https://packagist.org/packages/prokki/warlight2-bot-template)
[![Minimum PHP Version](https://img.shields.io/badge/PHP-%3D5.6.13-8892BF.svg)](https://php.net/)

This is a php bot template for Warlight AI Challenge 2 (http://theaigames.com/competitions/warlight-ai-challenge-2). 

Create a new project and install the template via Composer using the following command:

    composer require prokki/warlight2-bot-template
    
Create your own bot implementing the [Prokki\Warlight2BotTemplate\GamePlay\AIable](https://github.com/prokki/warlight2-bot-template/blob/master/src/GamePlay/AIable.php) interface.

Take a look to example class [RandomAI](https://github.com/prokki/warlight2-bot-template/blob/master/src/GamePlay/RandomAI.php) for further informations.

    class YOUR_AI implements Prokki\Warlight2BotTemplate\GamePlay\AIable
    {
    
        public function pickStartingRegion($player, $region_ids)
        {
            // put your code here
        }
        
        public function getAttackTransferMoves($player)
        {
            // put your code here
        }

        public function getPlaceMoves($player)
        {
            // put your code here
        }
    }

Links:
- Game challenge page: http://theaigames.com/competitions/warlight-ai-challenge-2
- Game source: https://github.com/theaigames/warlight2-engine
- Game viewer to visualize/play a (compatible) game: https://github.com/kefik/conquest-engine-gui
