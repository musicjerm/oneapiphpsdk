<?php

declare(strict_types = 1);

namespace Musicjerm\OneApiPhpSdk\Tests;

use Musicjerm\OneApiPhpSdk\Model\OneClient;
use PHPUnit\Framework\TestCase;

class OneClientTest extends TestCase
{
    private string $apiToken = 'api_key_goes_here';

    /** @test */
    public function itQueriesBooks(): void
    {
        // given that we have a client object
        $client = new OneClient($this->apiToken);

        // when calling the query function with valid arguments
        $client->oneQuery('book');

        // expected data
        $expected = '{"docs":[{"_id":"5cf5805fb53e011a64671582","name":"The Fellowship Of The Ring"},{"_id":"5cf58077b53e011a64671583","name":"The Two Towers"},{"_id":"5cf58080b53e011a64671584","name":"The Return Of The King"}],"total":3,"limit":1000,"offset":0,"page":1,"pages":1}';

        // a successful json encoded string is created
        $this->assertEquals($expected, $client->getJsonData());
    }

    /** @test */
    public function itQueriesAQuote(): void
    {
        // given that we have a client object
        $client = new OneClient($this->apiToken);

        // when calling the query function with valid arguments
        $client->oneQuery('quote', '5cd96e05de30eff6ebcce9ba');

        // expected data
        $expected = '{"docs":[{"_id":"5cd96e05de30eff6ebcce9ba","dialog":"All our hopes now lie with two little Hobbits...","movie":"5cd95395de30eff6ebccde5b","character":"5cd99d4bde30eff6ebccfea0","id":"5cd96e05de30eff6ebcce9ba"}],"total":1,"limit":1000,"offset":0,"page":1,"pages":1}';

        // a successful json encoded string is created
        $this->assertEquals($expected, $client->getJsonData());
    }

    /** @test */
    public function itQueriesCharacterQuotes(): void
    {
        // given that we have a client object
        $client = new OneClient($this->apiToken);

        // when calling the query function with valid arguments
        $client->oneQuery('character', '5cd99d4bde30eff6ebccfc8f', 'quote');

        // expected data
        $expected = '{"docs":[{"_id":"5cd96e05de30eff6ebcce81b","dialog":"Goodnight lads.","movie":"5cd95395de30eff6ebccde5d","character":"5cd99d4bde30eff6ebccfc8f","id":"5cd96e05de30eff6ebcce81b"},{"_id":"5cd96e05de30eff6ebccefa0","dialog":"Goodnight, lads.","movie":"5cd95395de30eff6ebccde5c","character":"5cd99d4bde30eff6ebccfc8f","id":"5cd96e05de30eff6ebccefa0"}],"total":2,"limit":1000,"offset":0,"page":1,"pages":1}';

        // a successful json encoded string is created
        $this->assertEquals($expected, $client->getJsonData());
    }
}