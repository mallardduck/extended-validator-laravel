<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\NotInIf;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class MutationTest extends BaseTest
{
    public function testExceptionNotInIfExpectsMoreThanZeroParameters()
    {
        $v = $this->getValidator()->make(
            [
                'email' => 'test@example.com',
            ],
            [
                'email' => 'not_in_if',
                'is_prod' => 'sometimes'
            ]
        );
        $this->expectExceptionCode(0);
        $this->expectException(\InvalidArgumentException::class);
        $v->fails();
    }

    public function testExceptionNotInIfExpectsMoreThanOneParameters()
    {
        $v = $this->getValidator()->make(
            [
                'email' => 'test@example.com',
                'is_prod' => true,
            ],
            [
                'email' => 'not_in_if:is_prod',
                'is_prod' => 'sometimes'
            ]
        );
        $this->expectExceptionCode(0);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Validation rule not_in_if requires at least 2 parameters.");
        $v->fails();
    }
}
