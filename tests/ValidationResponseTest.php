<?php

namespace Pollitofive\API\Tests;

class ValidationResponseTest extends TestCase
{
    /** @test */
    public function it_returns_validation_failed_response()
    {
        $response = api()->validation()->getContent();
        $expectedResponse = [
            'message' => 'Validation Failed please check the request attributes and try again.',
            'status'  => 422,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_validation_failed_response_with_passed_data()
    {
        $response = api()->validation('Name field is required, please check and try again.', ['name' => 'name field is required'])->getContent();
        $expectedResponse = [
            'message' => 'Name field is required, please check and try again.',
            'status'  => 422,
            'data'    => ['name' => 'name field is required'],
        ];

        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_validation_response_with_default_data()
    {
        $response = api()->validation()->getContent();
        $expectedResponse = [
            'status'  => 422,
            'message' => trans('api-response::messages.validation'),
            'data'    => [],
        ];

        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }
}
