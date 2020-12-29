<?php

namespace App\Tests\functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class getApiElementTest extends WebTestCase
{
    /** @test */
    public function getElement_successful()
    {
        $client = static::createClient();
        $client->request('GET', '/api/element/get/1');

        $elements = json_decode($client->getResponse()->getContent())->elements;

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(5, json_decode($elements));
    }

    /** @test */
    public function getElement_with_bad_id()
    {
        $client = static::createClient();
        $client->request('GET', '/api/element/get/12');

        $this->assertResponseStatusCodeSame(400);
        $this->assertSame(
            'This CheckList do not exist!!',
            json_decode($client->getResponse()->getContent())->message
        );
    }
}