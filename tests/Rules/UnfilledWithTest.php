<?php

namespace MallardDuck\OpinionatedValidator\Tests\Rules;

use MallardDuck\OpinionatedValidator\Tests\BaseTest;

class UnfilledWithTest extends BaseTest
{
    public function testValidateUnfilledWithNameExample()
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