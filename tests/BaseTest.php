<?php

namespace MallardDuck\OpinionatedValidator\Tests;

use Illuminate\Validation\Factory;
use MallardDuck\OpinionatedValidator\OpinionatedValidatorServiceProvider;
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
            OpinionatedValidatorServiceProvider::class
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