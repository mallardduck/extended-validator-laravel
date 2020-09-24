<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class PublicIpv4AddressTest extends BaseTest
{
    public function testValidateMacAddressExample()
    {
        $basicUnfilledRules = [
            'ip_address'  => 'sometimes|public_ipv4',
            'mac_address'   => 'sometimes',
        ];

        $v = $this->getValidator()->make([
            'ip_address' => '8.8.8.8',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '2001:4860:4860::8888', // Valid IP but ipv6 not ipv4.
            'mac_address' => 'I"M NOT AN MAC ADDRESS',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => 'fe80::/10',
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
