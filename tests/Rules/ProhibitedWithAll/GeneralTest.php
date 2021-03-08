<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\ProhibitedWithAll;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class GeneralTest extends BaseTest
{
    public function testValidateUnfilledWithAllNameExample()
    {
        $basicUnfilledWithAll = [
            'name' => 'prohibited_with_all:first_name,last_name',
            'first_name' => 'sometimes',
            'last_name' => 'sometimes'
        ];

        $v = $this->getValidator()->make(
            ['name' => 'Ricky Bobby'],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robertson'
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'last_name' => 'Robertson'
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());
    }

    public function testValidateUnfilledWithAllNullExample()
    {
        $basicUnfilledWithAll = [
            'name' => 'prohibited_with_all:first_name,last_name',
            'first_name' => 'sometimes',
            'last_name' => 'sometimes'
        ];

        $v = $this->getValidator()->make(
            [
                'name'          => null,
                'first_name'    => 'Ricky',
                'last_name'     => 'Bobby',
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name'          => 'Ricky Bobby',
                'first_name'    => null,
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name'          => 'Ricky Bobby',
                'first_name'    => null,
                'last_name'     => null,
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name'          => 'Ricky Bobby',
                'last_name'     => null,
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());
    }

    public function testValidateUnfilledWithAllManyPartsExample()
    {
        $basicUnfilledWithAll = [
            'name' => 'prohibited_with_all:first_name,middle_name,last_name',
            'first_name' => 'sometimes',
            'middle_name' => 'sometimes',
            'last_name' => 'sometimes'
        ];

        $v = $this->getValidator()->make(
            ['name' => 'Ricky Bobby'],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'middle_name' => 'Wallace',
                'last_name' => 'Robertson'
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'first_name' => 'Richard',
                'middle_name' => 'Wallace',
                'last_name' => 'Robertson'
            ],
            $basicUnfilledWithAll
        );
        $this->assertTrue($v->passes());
    }
}
