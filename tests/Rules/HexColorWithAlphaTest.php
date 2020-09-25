<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class HexColorWithAlphaTest extends BaseTest
{
    public function testValidateHexColorExample()
    {
        $basicUnfilledRules = [
            'background' => 'sometimes|hex_color_with_alpha',
            'foreground' => 'sometimes|hex_color_with_alpha',
        ];

        $v = $this->getValidator()->make([
            'background' => '#FF333', // With 100% alpha.
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'background' => '#3333', // INVALID: Codes must be 5 or 8 characters.
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'background' => 'E6333666', // With 90% alpha.
            'foreground' => '#FF000', // With 100% alpha.
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'background' => '##CC349725', // With 80% alpha, but INVALID due to extra hashtag.
            'foreground' => '00000000', // With 0% alpha.
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'background' => '#4D424242', // With 30% alpha.
            'foreground' => '80420', // With 50% alpha.
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'background' => '127.0.0.1', // INVALID: This is an IP address.
            'foreground' => '#40123', // With 25% alpha.
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());
    }
}
