<?php

namespace App\Tests\functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class getApiChecklistTest extends WebTestCase
{
    /** @test */
    public function get_successful()
    {
        $client = static::createClient();
        $client->request('GET', '/api/check_list/get');
        $this->assertResponseIsSuccessful('Welcome to your new controller!');
    }

    /** @test */
    public function get_with_id_successful()
    {
        $client = static::createClient();
        $id = 2;

        $client->request('GET', "/api/check_list/get/$id");

        $list = json_decode($client->getResponse()->getContent())->checkList;
        $tilte = json_decode($list)->title;

        $this->assertResponseIsSuccessful('Welcome to your new controller!');
        $this->assertSame("Liste n°1", $tilte);
    }
}