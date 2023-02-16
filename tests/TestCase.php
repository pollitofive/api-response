<?php

namespace Pollitofive\API\Tests;

use Pollitofive\API\ApiResponseServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(ApiResponseServiceProvider::class);
    }
}
