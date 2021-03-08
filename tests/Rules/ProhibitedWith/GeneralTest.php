<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\ProhibitedWith;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class GeneralTest extends BaseTest
{
    public function testValidateUnfilledWithNameExample()
    {
        $v = $this->getValidator()->make(
            [],
            [
                'name' => 'prohibited_with:first_name',
                'first_name' => 'sometimes'
            ]
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            ['name' => 'Ricky Bobby'],
            [
                'name' => 'prohibited_with:first_name,last_name',
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
                'name' => 'prohibited_with:first_name,last_name',
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
                'name' => 'prohibited_with:first_name,last_name',
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
                'first_name' => 'prohibited_with:name',
                'last_name' => 'prohibited_with:name'
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
                'first_name' => 'prohibited_with:name',
                'last_name' => 'prohibited_with:name'
            ]
        );
        $this->assertTrue($v->passes());
    }

    public function testValidateUnfilledWithNullExample()
    {
        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'last_name' => null
            ],
            [
                'name' => 'sometimes',
                'first_name' => 'prohibited_with:name',
                'last_name' => 'prohibited_with:name'
            ]
        );
        $this->assertTrue($v->passes());
    }
}
