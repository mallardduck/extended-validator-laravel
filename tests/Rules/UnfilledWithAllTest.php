<?php

namespace MallardDuck\UnfilledValidator\Tests\Rules;

use MallardDuck\UnfilledValidator\Tests\BaseTest;

class UnfilledWithAllTest extends BaseTest
{
    public function testValidateUnfilledWithAllNameExample()
    {
        $basicUnfilledWithAll = [
            'name' => 'unfilled_with:first_name,last_name',
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
        $this->assertTrue($v->fails());

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
}
