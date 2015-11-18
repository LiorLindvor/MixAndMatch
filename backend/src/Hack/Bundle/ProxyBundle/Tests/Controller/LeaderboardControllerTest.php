<?php

namespace Hack\Bundle\ProxyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeaderboardControllerTest extends WebTestCase
{
    public function testTop()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/leaderboard/top');
    }

}
