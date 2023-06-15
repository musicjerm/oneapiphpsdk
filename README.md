# MusicJerm/OneApiPhpSdk

[![Author](https://img.shields.io/badge/author-@musicjerm-blue.svg)](https://www.linkedin.com/in/musicjerm/)
[![Source Code](https://img.shields.io/badge/source-musicjerm/oneapiphpsdk-blue.svg)](https://github.com/musicjerm/oneapiphpsdk)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/thephpleague/flysystem/blob/master/LICENSE)
![php 8.0+](https://img.shields.io/badge/php-min%208.0.2-red.svg)

## The One SDK (for PHP) to Rule Them All
Are you a PHP dev?  Would you like an easy library to use and pull data from the one source API to rule them all?  Are you afraid of crossing Mordor to get your own API data?  Look no further.  The One API (for PHP) has your back.  Consider this your Samwise Gamgee to help you cross the scary trenches of the Mordor API.

It's really not all that scary, but we are here to give you a helping hand and make the journey easier.

## Installation
To install, please use `composer require musicjerm/oneapiphpsdk`

## How to use this marvelous SDK
Make sure to get your API key from https://the-one-api.dev/

After installation, simply include the library **Client** and make your calls as listed below!  Yes it is THAT easy!
```
<?php

namespace Your\App;

use Musicjerm\OneApiPhpSdk\Model\Client;

class yourClass
{
    private string $apiKey = 'put_your_api_key_here';

    public function getSomeData()
    {
        // create the client
        $oneApiClient = new Client($this->apiKey);

        // submit your query and access it using the ->getJsonData method
        $oneClient->oneQuery('quote', '5cd96e05de30eff6ebcce9ba');
        $response = $oneClient->getJsonData();

        // response is a json encoded string
        // decode it if necessary
        $arrayData = json_decode($response, false, 512, JSON_THROW_ON_ERROR)->docs;
        
        print_r($arrayData);
    }
}
```

`Client->oneQuery()` takes three arguments.  Only the first is required.
```
Client->oneQuery(string $mediaType, string $mediaId, string $quote);
```
Valid arguments are as follows:
* $mediaType - book, movie, character, quote, chapter
* $mediaId - this is the ID of one of the above movie types and will normally look like a string of characters
* $quote - This must be *movie* or *character* and **both of the first two arguments must be passed before you may pass this one**.  This will list all the quotes from movie or character.  If the first argument is not one of these, this parameter will be ignored.

A valid request might look like `$oneClient->oneQuery('quote', '5cd96e05de30eff6ebcce9ba');`

## Testing

PHPUnit tests are included under /tests.  To run them:
1. Make sure PHPUnit is installed `composer require --dev phpunit/phpunit`.
2. Update the api key in `tests/OneClientTest.php`.
3. From your project directory simply run `./vendor/bin/phpunit ./vendor/musicjerm/oneapiphpsdk/tests `.

For more info about PHPUnit, please visit https://docs.phpunit.de/en/10.2/index.html.
