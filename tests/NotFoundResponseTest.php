<?php

namespace Pollitofive\Tests;

use Pollitofive\API\Tests\TestCase;

class NotFoundResponseTest extends TestCase
{
    /** @test */
    public function it_returns_404_response()
    {
        $response = api()->notFound('No results for your query')->getContent();
        $expectedResponse = [
            'message' => 'No results for your query',
            'status'  => 404,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_404_response_with_default_config_message()
    {
        $response = api()->notFound()->getContent();
        $expectedResponse = [
            'message' => trans('api-response::messages.notfound'),
            'status'  => 404,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }
}
