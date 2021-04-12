<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\ProhibitedWithAll;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class MutationTest extends BaseTest
{
    public function testValidateProhibitedWithAllIncompleteExample()
    {
        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
            ],
            [
                'name' => 'prohibited_with_all:first_name',
                'first_name' => 'sometimes',
                'last_name' => 'sometimes'
            ]
        );
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Validation rule prohibited_with_all requires at least 2 parameters.");
        $v->fails();
    }

    public function testValidateProhibitedWithAllNameExample()
    {
        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'last_name' => 'Robertson'
            ],
            [
                'name' => 'prohibited_with_all:first_name,last_name',
                'first_name' => 'sometimes',
                'last_name' => 'sometimes'
            ]
        );
        self::assertTrue($v->fails());
        self::assertCount(1, $v->messages()->toArray());
        self::assertStringContainsString("first_name and last_name", $v->messages()->messages()['name'][0]);
    }

    public function testValidateProhibitedWithAllManyPartsExample()
    {
        $v = $this->getValidator()->make(
            [
                'name' => 'Ricky Bobby',
                'first_name' => 'Richard',
                'middle_name' => 'Wallace',
                'last_name' => 'Robertson'
            ],
            [
                'name' => 'prohibited_with_all:first_name,middle_name,last_name',
                'first_name' => 'sometimes',
                'middle_name' => 'sometimes',
                'last_name' => 'sometimes'
            ]
        );
        self::assertTrue($v->fails());
        self::assertCount(1, $v->messages()->toArray());
        self::assertStringContainsString(
            "first_name, middle_name and last_name",
            $v->messages()->messages()['name'][0]
        );
    }
}
