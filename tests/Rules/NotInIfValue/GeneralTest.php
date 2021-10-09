<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\NotInIfValue;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class GeneralTest extends BaseTest
{
    public function testValidateNotInIfValueExample()
    {
        $baseRules = [
            'size' => ['sometimes', 'in:small,medium,large', 'not_in_if_value:shape,square,large,super'],
            'shape' => ['required', 'in:square,rectangle'],
        ];
        $v = $this->getValidator()->make([
            'shape' => 'square'
        ], $baseRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'shape' => 'square',
            'size' => 'large'
        ], $baseRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'shape' => 'square',
            'size' => 'small'
        ], $baseRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'shape' => 'square',
            'size' => 'booger'
        ], $baseRules);
        $this->assertTrue($v->fails());
    }

    public function testValidateNotInIfValueNullExample()
    {
        $v = $this->getValidator()->make(
            [
                'email' => 'test@example.com',
                'is_prod' => null,
            ],
            [
                'email' => 'not_in_if_value:is_prod,true,test@example.com',
                'is_prod' => 'sometimes'
            ]
        );
        $this->assertTrue($v->passes());
    }
}
