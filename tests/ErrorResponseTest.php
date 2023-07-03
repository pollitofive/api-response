<?php

namespace Pollitofive\API\Tests;

class ErrorResponseTest extends TestCase
{
    /** @test */
    public function it_returns_error_with_default_response()
    {
        $response = api()->error()->getContent();
        $expectedResponse = [
            'status'  => 500,
            'message' => trans('api-response::messages.error'),
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_error_with_passed_parameters()
    {
        $response = api()
            ->error('error Accord, try later.', ['reference_code' => 345])
            ->getContent();
        $expectedResponse = [
            'status'  => 500,
            'message' => 'error Accord, try later.',
            'data'    => ['reference_code' => 345],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }
}
