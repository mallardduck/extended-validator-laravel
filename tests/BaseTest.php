<?php

namespace MallardDuck\UnfilledValidator\Tests;

use Illuminate\Validation\Factory;
use MallardDuck\UnfilledValidator\UnfilledValidatorServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            UnfilledValidatorServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }

    protected function getValidator(): Factory
    {
        return $this->app->get('validator');
    }
}