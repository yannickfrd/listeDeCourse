<?php

namespace App\Tests\functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class putApiChecklistTest extends WebTestCase
{
    /** @test */
    public function put_successful()
    {
        $client = static::createClient();
        $id = 1;
        $data = [
            "title" => "Autre titre",
            "colorHexa" => "#ffffff"
        ];
        $client->xmlHttpRequest(
            'PUT', "/api/check_list/put/$id",
            ['exceptions' => false], [], ['Content-Type' => 'application/json'],
            json_encode($data)
        );

        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(
            'The check list is correctly updated',
            json_decode($client->getResponse()->getContent())->message
        );
    }

    /** @test
     * @param array $data
     * @param string $message
     * @param int $statusCode
     * @dataProvider list_bad_credentials
     */
    public function put_bad_credentials(array $data, string $message, int $statusCode)
    {
        $client = static::createClient();
        $id = 1;
        $client->xmlHttpRequest(
            'PUT', "/api/check_list/put/$id",
            ['exceptions' => false], [], ['Content-Type' => 'application/json'],
            json_encode($data)
        );

        $this->assertResponseStatusCodeSame($statusCode, $client->getResponse()->getStatusCode());
        $this->assertSame($message, json_decode($client->getResponse()->getContent())->message);
    }

    public function list_bad_credentials(): iterable
    {
        yield [
            [
                "title" => "",
                "colorHexa" => "#ffffff"
            ],
            "The title can not to be null",
            400
        ];
        yield [
            [
                "title" => "Un autre titre",
                "colorHexa" => ""
            ],
            "The check list is correctly updated",
            200
        ];
        yield [
            [
                "title" => "Un autre titre"
            ],
            "The check list is correctly updated",
            200
        ];
        yield [
            [
                "title" => "U",
                "colorHexa" => "#ffffff"
            ],
            "This value is too short min 3 char!!",
            400
        ];
    }
}