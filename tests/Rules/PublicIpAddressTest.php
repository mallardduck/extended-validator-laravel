<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTestCase;

class PublicIpAddressTest extends BaseTestCase
{
    public function testValidateMacAddressExample()
    {
        $basicUnfilledRules = [
            'ip_address'  => 'sometimes|public_ip',
            'mac_address'   => 'sometimes',
        ];

        $v = $this->getValidator()->make([
            'ip_address' => '8.8.8.8',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '127.0.0.1',
            'mac_address' => 'I"M NOT AN MAC ADDRESS',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '192.168.1.1',
            'mac_address' => 'I"M NOT AN MAC ADDRESS',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '1.1.1.1',
            'mac_address' => '00:A0:C9:14:C8:29',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());
    }
}
