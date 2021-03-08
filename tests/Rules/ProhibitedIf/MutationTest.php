<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\ProhibitedIf;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class MutationTest extends BaseTest
{
    public function testValidateUnfilledIfIncompleteExample()
    {

        $v = $this->getValidator()->make([
            'shape' => 'none',
            'size'  => 25
        ], [
            'shape'  => 'required',
            'size'   => 'prohibited_if',
        ]);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Validation rule prohibited_if requires at least 1 parameters.");
        $v->fails();
    }
}
