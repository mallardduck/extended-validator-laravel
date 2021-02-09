<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class UnfilledWithAllMutationTest extends BaseTest
{
    public function testValidateUnfilledWithAllIncompleteExample()
    {
        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
            ],
            [
                'name' => 'unfilled_with_all:first_name',
                'first_name' => 'sometimes',
                'last_name' => 'sometimes'
            ]
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Validation rule unfilled_with_all requires at least 2 parameters.");
        $v->fails();
    }

    public function testValidateUnfilledWithAllNameExample()
    {
        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robertson'
            ],
            [
                'name' => 'unfilled_with_all:first_name,last_name',
                'first_name' => 'sometimes',
                'last_name' => 'sometimes'
            ]
        );
        self::assertTrue($v->fails());
        self::assertCount(1, $v->messages()->toArray());
        self::assertStringContainsString("first_name and last_name", $v->messages()->messages()['name'][0]);
    }

    public function testValidateUnfilledWithAllManyPartsExample()
    {
        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'middle_name' => 'Wallace',
                'last_name' => 'Robertson'
            ],
            [
                'name' => 'unfilled_with_all:first_name,middle_name,last_name',
                'first_name' => 'sometimes',
                'middle_name' => 'sometimes',
                'last_name' => 'sometimes'
            ]
        );
        self::assertTrue($v->fails());
        self::assertCount(1, $v->messages()->toArray());
        self::assertStringContainsString("first_name, middle_name and last_name", $v->messages()->messages()['name'][0]);
    }
}
