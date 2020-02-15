<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use App\DataFixtures\EventFixtures;

class AddEventTest extends WebTestCase
{
    use FixturesTrait;

    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->loadFixtures([
            EventFixtures::class,
        ]);
    }
    public function testAddEvent()
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/events');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
