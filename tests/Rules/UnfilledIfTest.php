<?php

namespace MallardDuck\OpinionatedValidator\Tests\Rules;

use MallardDuck\OpinionatedValidator\Tests\BaseTest;

class UnfilledIfTest extends BaseTest
{
    public function testValidateUnfilledIf()
    {
        $basicUnfilledRules = [
            'shape'  => 'required',
            'size'   => 'required_if:shape,square|unfilled_if:shape,rect',
            'height' => 'unfilled_if:shape,square',
            'width'  => 'unfilled_if:shape,square',
        ];

        $v = $this->getValidator()->make(['shape' => 'none'], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'shape' => 'square',
            'size' => '42',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'shape' => 'square',
            'size' => '42',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'shape' => 'square',
            'size' => '42',
            'height' => '64',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'shape' => 'rect',
            'size' => '42',
            'height' => '64',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'shape' => 'rect',
            'height' => '64',
            'width' => '96',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());
    }
}