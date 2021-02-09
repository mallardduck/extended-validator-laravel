<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class UnfilledWithMutationTest extends BaseTest
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
                'last_name' => 'unfilled_with'
            ]
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Validation rule unfilled_with requires at least 1 parameters.");
        $v->fails();
    }
}
