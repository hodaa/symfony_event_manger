<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddEventTest extends WebTestCase
{
    public function testAddEvent()
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/events');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
