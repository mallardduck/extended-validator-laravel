<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules\ProhibitedIf;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class SpecialTest extends BaseTest
{
    public function testValidateProhibitedIfBooleanExample()
    {
        $basicUnfilledRules = [
            'equal'  => 'required',
            'size'   => 'prohibited_if:equal,false',
            'height' => 'prohibited_if:equal,true',
            'width'  => 'prohibited_if:equal,true',
        ];

        $v = $this->getValidator()->make([
            'equal' => true,
            'size' => '42',
            'height' => 'null',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'equal' => true,
            'size' => '42',
            'height' => '64',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'equal' => false,
            'size' => '42',
            'height' => '64',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'equal' => false,
            'height' => '64',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());
    }

    public function testValidateProhibitedIfNullExample()
    {
        $basicUnfilledRules = [
            'equal'  => 'sometimes',
            'size'   => 'prohibited_if:equal,true,null',
            'height' => 'prohibited_if:equal,false,null',
            'width'  => 'prohibited_if:equal,false',
            'depth'  => 'prohibited_if:equal,false',
        ];

        $v = $this->getValidator()->make([
            'equal' => null,
            'size' => '42',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'equal' => null,
            'size' => 'null',
            'height' => '64',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'equal' => null,
            'size' => '42',
            'height' => 'null',
            'width' => 'null',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'equal' => null,
            'height' => '64',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'equal' => null,
            'width' => '96',
            'depth' => '42'
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());
    }
}
