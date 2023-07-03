<?php

namespace Pollitofive\API\Tests;

class ForbiddenResponseTest extends TestCase
{
    /** @test */
    public function it_returns_forbidden_with_default_response()
    {
        $response = api()->forbidden()->getContent();
        $expectedResponse = [
            'status'  => 403,
            'message' => trans('api-response::messages.forbidden'),
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_forbidden_with_passed_parameters()
    {
        $response = api()
            ->forbidden('No access.', ['reference_code' => 345])
            ->getContent();
        $expectedResponse = [
            'status'  => 403,
            'message' => 'No access.',
            'data'    => ['reference_code' => 345],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }
}
