<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\NotInIfValue;

use MallardDuck\ExtendedValidator\Tests\BaseTestCase;

class MutationTest extends BaseTestCase
{
    public function testExceptionNotInIfValueExpectsMoreThanZeroParameters()
    {
        $v = $this->getValidator()->make(
            [
                'email' => 'test@example.com',
            ],
            [
                'email' => 'not_in_if_value',
                'is_prod' => 'sometimes'
            ]
        );
        $this->expectExceptionCode(0);
        $this->expectException(\InvalidArgumentException::class);
        $v->fails();
    }

    public function testExceptionNotInIfValueExpectsMoreThanOneParameters()
    {
        $v = $this->getValidator()->make(
            [
                'email' => 'test@example.com',
            ],
            [
                'email' => 'not_in_if_value:is_prod',
                'is_prod' => 'sometimes'
            ]
        );
        $this->expectExceptionCode(0);
        $this->expectException(\InvalidArgumentException::class);
        $v->fails();
    }

    public function testExceptionNotInIfValueExpectsMoreThanTwoParameters()
    {
        $v = $this->getValidator()->make(
            [
                'size' => 'test@example.com',
                'shape' => 'square',
            ],
            [
                'size' => ['sometimes', 'in:small,medium,large', 'not_in_if_value:shape,square'],
                'shape' => ['required', 'in:square,rectangle'],
            ]
        );
        $this->expectExceptionCode(0);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Validation rule not_in_if_value requires at least 3 parameters.");
        $v->fails();
    }
}
