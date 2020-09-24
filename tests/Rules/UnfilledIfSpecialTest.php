<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class UnfilledIfSpecialTest extends BaseTest
{
    public function testValidateUnfilledIfBooleanExample()
    {
        $basicUnfilledRules = [
            'equal'  => 'required',
            'size'   => 'unfilled_if:equal,false',
            'height' => 'unfilled_if:equal,true',
            'width'  => 'unfilled_if:equal,true',
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

    public function testValidateUnfilledIfNullExample()
    {
        $basicUnfilledRules = [
            'equal'  => 'sometimes',
            'size'   => 'unfilled_if:equal,true,null',
            'height' => 'unfilled_if:equal,false,null',
            'width'  => 'unfilled_if:equal,false',
            'depth'  => 'unfilled_if:equal,false',
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
