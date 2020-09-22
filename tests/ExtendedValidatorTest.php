<?php

namespace MallardDuck\OpinionatedValidator\Tests;

use Illuminate\Validation\Factory;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use MallardDuck\OpinionatedValidator\OpinionatedValidatorServiceProvider;
use Orchestra\Testbench\TestCase;

class ExtendedValidatorTest extends TestCase
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

    private function getValidator(): Factory
    {
        return $this->app->get('validator');
    }

    public function testValidateUnfilledIf()
    {
        $basicUnfilledRules = [
            'mode' => 'required',
            'full_name' => 'unfilled_if:mode,split',
            'first_name' => 'required_if:mode,split',
            'last_name' => 'required_if:mode,split',
        ];



        $v = $this->getValidator()->make(['mode' => 'none'], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'mode' => 'split',
            'first_name' => 'Richard',
            'last_name' => 'Bobby',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'mode' => 'split',
            'full_name' => 'Ricky Bobby',
            'first_name' => 'Richard',
            'last_name' => 'Bobby',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'mode' => 'split',
            'full_name' => 'Ricky Bobby',
            'last_name' => 'Bobby',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $basicUnfilledRules = [
            'mode' => 'required',
            'full_name' => 'required_if:mode,single',
            'first_name' => 'unfilled_if:mode,single',
            'last_name' => 'unfilled_if:mode,single',
        ];
        $v = $this->getValidator()->make([
            'mode' => 'single',
            'full_name' => 'Ricky Bobby',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'mode' => 'single',
            'full_name' => 'Ricky Bobby',
            'last_name' => 'Bobby',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());
    }

    public function testValidateUnfilledWith()
    {
        $v = $this->getValidator()->make(
            [],
            [
                'name' => 'unfilled_with:first_name',
                'first_name' => 'sometimes'
            ]
        );

        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            ['name' => 'Ricky Bobby'],
            [
                'name' => 'unfilled_with:first_name,last_name',
                'first_name' => 'sometimes'
            ]
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robertson'
            ],
            [
                'name' => 'unfilled_with:first_name,last_name',
                'first_name' => 'sometimes',
                'last_name' => 'sometimes'
            ]
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'last_name' => 'Robertson'
            ],
            [
                'name' => 'unfilled_with:first_name,last_name',
                'first_name' => 'sometimes'
            ]
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            [
                'name' => 'sometimes',
                'first_name' => 'unfilled_with:name',
                'last_name' => 'unfilled_with:name'
            ]
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            [
                'name' => 'sometimes',
                'first_name' => 'unfilled_with:name',
                'last_name' => 'unfilled_with:name'
            ]
        );
        $this->assertTrue($v->passes());
    }
}