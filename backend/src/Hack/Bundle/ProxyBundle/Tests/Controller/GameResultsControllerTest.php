<?php

namespace Hack\Bundle\ProxyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameResultsControllerTest extends WebTestCase
{
    public function testStore()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/result/store');
    }

    public function testGetfullgameresult()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/result/full-game');
    }

}
