<?php

namespace MallardDuck\ExtendedValidator\Tests;

use Illuminate\Validation\Factory;
use MallardDuck\ExtendedValidator\ExtendedValidatorServiceProvider;
use Orchestra\Testbench\TestCase;
use ReflectionObject;

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
            ExtendedValidatorServiceProvider::class
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

    // My own helpers...
    protected function getPrivatePropertyValueFromObject(object $object, string $propertyName)
    {
        $objectReflection = new ReflectionObject($object);
        $reflectedProperty = $objectReflection->getProperty($propertyName);
        $reflectedProperty->setAccessible(true);
        $propertyValue = $reflectedProperty->getValue($object);
        $reflectedProperty->setAccessible(false);

        return $propertyValue;
    }
}
