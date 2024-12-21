<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\ProhibitedWithAll;

use MallardDuck\ExtendedValidator\Tests\BaseTestCase;

class GeneralTest extends BaseTestCase
{
    public function testValidateProhibitedWithAllNameExample()
    {
        $basicProhibitedWithAll = [
            'name' => 'prohibited_with_all:first_name,last_name',
            'first_name' => 'sometimes',
            'last_name' => 'sometimes'
        ];

        $v = $this->getValidator()->make(
            ['name' => 'Ricky Bobby'],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robertson'
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'last_name' => 'Robertson'
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());
    }

    public function testValidateProhibitedWithAllNullExample()
    {
        $basicProhibitedWithAll = [
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
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name'          => 'Ricky Bobby',
                'first_name'    => null,
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name'          => 'Ricky Bobby',
                'first_name'    => null,
                'last_name'     => null,
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name'          => 'Ricky Bobby',
                'last_name'     => null,
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());
    }

    public function testValidateProhibitedWithAllManyPartsExample()
    {
        $basicProhibitedWithAll = [
            'name' => 'prohibited_with_all:first_name,middle_name,last_name',
            'first_name' => 'sometimes',
            'middle_name' => 'sometimes',
            'last_name' => 'sometimes'
        ];

        $v = $this->getValidator()->make(
            ['name' => 'Ricky Bobby'],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'middle_name' => 'Wallace',
                'last_name' => 'Robertson'
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robert'
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'first_name' => 'Richard',
                'middle_name' => 'Wallace',
                'last_name' => 'Robertson'
            ],
            $basicProhibitedWithAll
        );
        $this->assertTrue($v->passes());
    }
}
