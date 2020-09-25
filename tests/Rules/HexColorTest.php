<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class HexColorTest extends BaseTest
{
    public function testValidateHexColorExample()
    {
        $basicUnfilledRules = [
            'background' => 'sometimes|hex_color',
            'foreground' => 'sometimes|hex_color',
        ];

        $v = $this->getValidator()->make([
            'background' => '#333',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'background' => '#3333', // INVALID: Codes must be 3 or 6 characters.
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'background' => '333666',
            'foreground' => '#000',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'background' => '#349725',
            'foreground' => '00000000', // INVALID: Hex codes with transparency don't work.
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'background' => '#424242',
            'foreground' => '420',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'background' => '127.0.0.1', // INVALID: This is an IP address.
            'foreground' => '#123',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());
    }
}
