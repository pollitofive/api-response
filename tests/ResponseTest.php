<?php

namespace Pollitofive\Tests;

use Illuminate\Http\JsonResponse;
use Pollitofive\API\Facades\API;
use Pollitofive\API\Tests\TestCase;
use stdClass;

class ResponseTest extends TestCase
{
    /** @test */
    public function it_returns_response_object_with_array()
    {
        $response = API::response(200, 'New Response', []);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /** @test */
    public function it_returns_response_object_with_object()
    {
        $data = [];
        $data['foo'] = 'foo';
        $data['bar'] = 'bar';
        $data['baz'] = 'baz';
        $response = API::response(200, 'New Response', $data);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /** @test */
    public function user_can_edit_default_response_keys()
    {
        config()->set('api.keys', [
            'status'  => 'newStatus',
            'message' => 'newMessage',
            'data'    => 'newData',
        ]);

        $response = api()->ok()->getContent();
        $expectedResponse = [
            'newStatus'  => 200,
            'newMessage' => trans('api-response::messages.success'),
            'newData'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_string_api_status_code()
    {
        $response = api()->ok()->getContent();

        $this->assertIsString(json_decode($response, 1)['status']);
    }

    /** @test */
    public function user_can_edit_default_stringify_setting()
    {
        config()->set('api.stringify', false);

        $response = api()->ok()->getContent();

        $this->assertIsInt(json_decode($response, 1)['status']);
    }

    /** @test */
    public function it_returns_response_from_base_helper_function()
    {
        $response = api(403, 'Forbidden response message', [])->getContent();
        $expectedResponse = [
            'status'  => 403,
            'message' => 'Forbidden response message',
            'data'    => [],
        ];

        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_extra_parameters()
    {
        // using the api()->response()
        $response = api()->response(
            200,
            'New Response',
            ['name'      => 'Joe Doe'],
            ['code'      => 30566],
            ['reference' => 'ERROR-2019-09-14']
        )->getContent();
        $expectedResponse = [
            'status'    => 200,
            'message'   => 'New Response',
            'data'      => ['name' => 'Joe Doe'],
            'code'      => 30566,
            'reference' => 'ERROR-2019-09-14',
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));

        // using the facade
        $response = API::response(
            200,
            'New Response',
            ['name'      => 'Joe Doe'],
            ['code'      => 30566],
            ['reference' => 'ERROR-2019-09-14']
        )->getContent();
        $this->assertEquals($expectedResponse, json_decode($response, 1));

        // using api() directly
        $response = api(
            200,
            'New Response',
            ['name'      => 'Joe Doe'],
            ['code'      => 30566],
            ['reference' => 'ERROR-2019-09-14']
        )->getContent();
        $this->assertEquals($expectedResponse, json_decode($response, 1));

        // extra data as part of the same array
        $response = api()->response(
            200,
            'New Response',
            ['name' => 'Joe Doe'],
            ['code' => 30566, 'reference' => 'ERROR-2019-09-14']
        )->getContent();
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    // TODO (3 test): test validation errors, default message validation, serer error response
}
