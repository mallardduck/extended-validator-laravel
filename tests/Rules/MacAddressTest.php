<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTestCase;

class MacAddressTest extends BaseTestCase
{
    public function testValidateMacAddressExample()
    {
        $basicUnfilledRules = [
            'ip_address'  => 'sometimes|ip',
            'mac_address'   => 'sometimes|mac_address',
        ];

        $v = $this->getValidator()->make([
            'ip_address' => '127.0.0.1',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '127.0.0.1',
            'mac_address' => '00:A0:C9:14:C8:29',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '127.0.0.1',
            'mac_address' => 'I"M NOT AN MAC ADDRESS',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());
    }
}
