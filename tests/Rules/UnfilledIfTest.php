<?php

namespace MallardDuck\UnfilledValidator\Tests\Rules;

use MallardDuck\UnfilledValidator\Tests\BaseTest;

class UnfilledIfTest extends BaseTest
{
    public function testValidateUnfilledIfShapeGeneratorExample()
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

    public function testValidateUnfilledIfNameExample()
    {
        $basicUnfilledRules = [
            'mode'       => 'required',
            'full_name'  => 'required_if:mode,full|unfilled_if:mode,split',
            'first_name' => 'unfilled_if:mode,full',
            'last_name'  => 'unfilled_if:mode,full',
        ];

        $v = $this->getValidator()->make([
            'mode' => 'none'
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'mode'      => 'full',
            'full_name' => 'Ricky Bobby',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'mode'       => 'full',
            'full_name'  => 'Ricky Bobby',
            'first_name' => 'Richard',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'mode'       => 'full',
            'full_name'  => 'Ricky Bobby',
            'first_name' => 'Richard',
            'last_name'  => 'Robertson',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'mode'       => 'split',
            'full_name'  => 'Ricky Bobby',
            'first_name' => 'Richard',
            'last_name'  => 'Robertson',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'mode'       => 'split',
            'first_name' => 'Richard',
            'last_name'  => 'Robertson',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());
    }
}