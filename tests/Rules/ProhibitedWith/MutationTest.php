<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\ProhibitedWith;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class MutationTest extends BaseTest
{
    public function testValidateUnfilledWithIncompleteExample()
    {

        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'last_name' => 'Bobby',
            ],
            [
                'name' => 'sometimes',
                'last_name' => 'prohibited_with'
            ]
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Validation rule prohibited_with requires at least 1 parameters.");
        $v->fails();
    }
}
