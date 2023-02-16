<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\ProhibitedWith;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class DeprecationTest extends BaseTest
{
    public function testValidateProhibitedWithNameExample()
    {
        $v = $this->getValidator()->make(
            [],
            [
                'name' => 'sometimes',
                'first_name' => ['sometimes', 'prohibits:name'],
            ]
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            ['name' => 'Ricky Bobby'],
            [
                'name' => 'sometimes',
                'first_name' => ['sometimes', 'prohibits:name'],
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
                'name' => 'sometimes',
                'first_name' => ['sometimes', 'prohibits:name'],
                'last_name' => ['sometimes', 'prohibits:name'],
            ]
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'last_name' => 'Robertson'
            ],
            [
                'name' => 'sometimes',
                'last_name' => ['sometimes', 'prohibits:name'],
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
                'name' => ['sometimes', 'prohibits:first_name,last_name'],
                'first_name' => ['sometimes', 'prohibits:name'],
                'last_name' => ['sometimes', 'prohibits:name'],
            ]
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            [
                'name' => ['sometimes', 'prohibits:first_name,last_name'],
                'first_name' => ['sometimes', 'prohibits:name'],
                'last_name' => ['sometimes', 'prohibits:name'],
            ]
        );
        $this->assertTrue($v->passes());
    }

    public function testValidateProhibitedWithNullExample()
    {
        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'last_name' => null
            ],
            [
                'name' => ['sometimes', 'prohibits:first_name,last_name'],
                'first_name' => ['sometimes', 'prohibits:name'],
                'last_name' => ['sometimes', 'prohibits:name'],
            ]
        );
        // As of Laravel 9.x this should pass.
        if (str_starts_with(app()->version(), '8')) {
            $this->assertTrue($v->fails());
        } else {
            $this->assertTrue($v->passes());
        }
    }
}
