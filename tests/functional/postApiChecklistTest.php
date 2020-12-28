<?php

namespace App\Tests\functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class postApiChecklistTest extends WebTestCase
{
    /** @test */
    public function post_successful()
    {
        $client = static::createClient();
        $client->xmlHttpRequest(
            'POST', '/api/check_list/post',
            [], [], ['Content-Type' => 'application/json'],
            '{"title":"un titre", "color":"#FFFFFF" }'
        );

        $this->assertResponseIsSuccessful('The check list is correctly save');
        $this->assertResponseStatusCodeSame(201, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider providerInvalidDatas
     * @param array $data
     * @param string $message
     */
    public function post_do_not_ok(array $data, string $message): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest(
            'POST', '/api/check_list/post',
            ['exceptions' => false], [], ['Content-Type' => 'application/json'],
            json_encode($data)
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertSame(
            $message,
            json_decode($client->getResponse()->getContent())->message
        );
    }

    public function providerInvalidDatas(): iterable
    {
        yield [
            [ "title" => "" ],
            'This value can\'t to be blank!!'
        ];
        yield [
            [ "title" => "hs" ],
            'This value is so short min 3 char!!'
        ];
        yield [
            [ "title" => "hshshshshshshshshshshshshshshshshshshshshshsshshshshs" ],
            'This value can\'t be exceed 50 char!!'
        ];
    }
}