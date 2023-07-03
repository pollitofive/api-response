<?php

namespace Pollitofive\Tests;

use Pollitofive\API\Facades\API;
use Pollitofive\API\Tests\TestCase;

class OkResponseTest extends TestCase
{
    /** @test */
    public function it_returns_ok_response()
    {
        $response = API::ok('this is message', [])->getContent();
        $expectedResponse = [
            'message' => 'this is message',
            'status'  => 200,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_ok_response_from_helper_function()
    {
        $response = api()->ok('this is message', [])->getContent();
        $expectedResponse = [
            'message' => 'this is message',
            'status'  => 200,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_ok_response_from_success_helper_function()
    {
        $response = api()->success('this is message', [])->getContent();
        $expectedResponse = [
            'message' => 'this is message',
            'status'  => 200,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_ok_response_from_ok_helper_function()
    {
        $response = ok('this is message', [])->getContent();
        $expectedResponse = [
            'message' => 'this is message',
            'status'  => 200,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_ok_response_from_success_alias_helper_function()
    {
        $response = success('this is message', [])->getContent();
        $expectedResponse = [
            'message' => 'this is message',
            'status'  => 200,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_ok_response_with_default_message()
    {
        $response = api()->ok()->getContent();
        $expectedResponse = [
            'message' => trans('api-response::messages.success'),
            'status'  => 200,
            'data'    => [],
        ];
        $this->assertEquals($expectedResponse, json_decode($response, 1));
    }

    /** @test */
    public function it_returns_count_if_enabled_and_countable()
    {
        config()->set('api.include_data_count', true);
        $response = api()->ok('User list', ['name1' => 'name1', 'name2' => 'name2'])->getContent();
        $this->assertEquals(true, property_exists(json_decode($response), 'data_count'));
        $this->assertEquals(2, json_decode($response, 1)['data_count']);
    }

    /** @test */
    public function it_does_not_return_count_if_enabled_and_not_countable()
    {
        config()->set('api.include_data_count', true);
        $response = api()->ok('User list', [])->getContent();
        $this->assertEquals(false, property_exists(json_decode($response), 'data_count'));
    }

    /** @test */
    public function user_can_change_default_data_count_name()
    {
        config()->set('api.include_data_count', true);
        config()->set('api.keys.data_count', 'count_of_data');
        $response = api()->ok('User list', ['name1' => 'name1', 'name2' => 'name2'])->getContent();
        $this->assertEquals(true, property_exists(json_decode($response), 'count_of_data'));
    }

    /** @test */
    public function it_returns_count_as_a_string_if_enabled()
    {
        config()->set('api.include_data_count', true);
        config()->set('api.stringify', true);

        $response = api()->ok('User list', ['name1' => 'name1', 'name2' => 'name2'])->getContent();
        $this->assertIsString(json_decode($response, 1)['data_count']);
        $this->assertEquals(true, 2, json_decode($response, 1)['data_count']);
    }
}
