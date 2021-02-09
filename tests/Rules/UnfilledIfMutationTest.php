<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class UnfilledIfMutationTest extends BaseTest
{
    public function testValidateUnfilledIfIncompleteExample()
    {

        $v = $this->getValidator()->make([
            'shape' => 'none',
            'size'  => 25
        ], [
            'shape'  => 'required',
            'size'   => 'unfilled_if',
        ]);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Validation rule unfilled_if requires at least 1 parameters.");
        $v->fails();
    }
}
