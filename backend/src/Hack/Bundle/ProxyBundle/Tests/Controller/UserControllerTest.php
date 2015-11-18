<?php

namespace Hack\Bundle\ProxyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/register');
    }

    public function testAuthorize()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/authorize');
    }

    public function testGetstatistics()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/get-statistics');
    }

}
