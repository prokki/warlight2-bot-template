## Warlight2BotTemplate

[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](https://github.com/prokki/warlight2-bot/blob/master/LICENSE)
[![Packagist](https://img.shields.io/badge/Packagist-0.1.1-blue.svg?style=flat)](https://packagist.org/packages/prokki/warlight2-bot-template)
[![Minimum PHP Version](https://img.shields.io/badge/PHP-%3D5.6.13-8892BF.svg)](https://php.net/)

This is a php bot template for Warlight AI Challenge 2 (http://theaigames.com/competitions/warlight-ai-challenge-2). 

> Note: The project is in beta stage. Feel free to report any issues you encounter.

Create a new project and install the template via Composer using the following command:

    composer require prokki/warlight2-bot-template
    
Create your own bot implementing the [Prokki\Warlight2BotTemplate\GamePlay\AIable](src/Bot/AIable.php) interface.

Take a look to example class [Prokki\Warlight2BotTemplate\GamePlay\RandomAI](src/Bot/RandomAI.php) for further informations.

    class YOUR_AI implements Prokki\Warlight2BotTemplate\GamePlay\AIable
    {
        /**
         * Returns the id of the region to pick.
         *
         * @param Environment $environment
         * @param integer[]   $region_ids
         *
         * @return PickMove
         */
        public function getPickMove(Environment $environment, $region_ids)
        {
            // put your code here
        }
        
        public function getAttackTransferMoves(Environment $environment)
        {
            // put your code here
        }

        public function getPlaceMoves(Environment $environment)
        {
            // put your code here
        }
    }

Links:
- Game challenge page: http://theaigames.com/competitions/warlight-ai-challenge-2
- Game source: https://github.com/theaigames/warlight2-engine
- Game viewer to visualize/play a (compatible) game: https://github.com/kefik/conquest-engine-gui
