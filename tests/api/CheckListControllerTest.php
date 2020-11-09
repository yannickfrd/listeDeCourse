<?php

namespace App\Tests\api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CheckListControllerTest extends WebTestCase {
    public function statusCode($link, $method="GET", $status=200, $data=null) {
        $client = static::createClient();
        $client->xmlHttpRequest($method, $link, [], [], [], $data);
        $this->assertEquals($status, $client->getResponse()->getStatusCode());
    }

    public function testGetCheckList() {
        $this->statusCode('/api/check_list/get');
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    public function testGetTheCheckList() {
        $this->statusCode('/api/check_list/get/3');
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    public function testPostCheckList() {
        $data = '{"title": "Liste n°5"}';
        $this->statusCode('/api/check_list/post', 'POST', 201, $data);
    }

    public function testPutCheckList() {
        $data = '{"title": "Test put", "colorHexa": "#99ccff"}';
        $this->statusCode('/api/check_list/put/33', 'PUT', 202, $data);
    }

    public function testDeleteCheckList() {
        $this->statusCode('/api/check_list/delete/34', 'DELETE', 202);
    }
}