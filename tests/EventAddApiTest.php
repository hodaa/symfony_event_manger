<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class EventAddApiTest extends WebTestCase
{
    public function testAddEvent()
    {
        $client = static::createClient();

        $response = $client->request(
            Request::METHOD_POST,
            '/api/v1/events',
            [
                "name" => 'Event1',
                "location" => 'Egypt',
                "attendance" => 2,
                "period" => "30",
                "type" => 1,
                "date" => "2020-02-20"
            ]
        );


        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $responseContent = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame("Event created", $responseContent['message']);
    }
}
