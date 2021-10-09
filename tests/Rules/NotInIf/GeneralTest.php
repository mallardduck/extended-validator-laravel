<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\NotInIf;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class GeneralTest extends BaseTest
{
    public function testValidateNotInIfExample()
    {
        $baseRules = [
            'email' => ['not_in_if:is_prod,test@example.com,other-test@example.com'],
            'is_prod' => 'sometimes'
        ];
        $v = $this->getValidator()->make([], $baseRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            ['email' => 'test@example.com'],
            $baseRules
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'email' => 'test@example.com',
                'is_prod' => true,
            ],
            $baseRules
        );
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make(
            [
                'email' => 'other-test@example.com',
                'is_prod' => true,
            ],
            $baseRules
        );
        $this->assertTrue($v->fails());
        self::assertEquals("The selected email is invalid.", $v->messages()->messages()['email'][0]);

        $v = $this->getValidator()->make(
            [
                'email' => 'a-working-email@example.com',
                'is_prod' => true,
            ],
            $baseRules
        );
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make(
            [
                'email' => 'test@example.com',
                'is_prod' => false,
            ],
            $baseRules
        );
        $this->assertTrue($v->passes());
    }

    public function testValidateNotInIfNullExample()
    {
        $v = $this->getValidator()->make(
            [
                'email' => 'test@example.com',
                'is_prod' => null,
            ],
            [
                'email' => 'not_in_if:is_prod,true,test@example.com',
                'is_prod' => 'sometimes'
            ]
        );
        $this->assertTrue($v->passes());
    }
}
