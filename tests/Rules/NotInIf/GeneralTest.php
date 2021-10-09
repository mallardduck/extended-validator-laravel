<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\NotInIf;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class GeneralTest extends BaseTest
{
    public function testValidateProhibitedWithNameExample()
    {
        $baseRules = [
            'email' => 'not_in_if:is_prod,true,test@example.com',
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
                'email' => 'test@example.com',
                'is_prod' => false,
            ],
            $baseRules
        );
        $this->assertTrue($v->passes());
    }

    public function testValidateProhibitedWithNullExample()
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
