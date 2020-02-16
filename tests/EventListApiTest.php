<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use App\DataFixtures\EventFixtures;

class EventListApiTest extends WebTestCase
{
    use FixturesTrait;

    public function setUp()
    {
        $this->loadFixtures([
            EventFixtures::class,
        ]);
    }
    public function testAddEvent()
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/events');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame([
            "id" => 1,
            "name" => 'Event1',
            "location" => 'Egypt',
            "attendance" => '1',
            "period" => "30",
            "type" => "Call"
            ], $responseContent['data'][0]);
    }
}
