<?php

namespace MallardDuck\ExtendedValidator\Tests\Rules;

use MallardDuck\ExtendedValidator\Tests\BaseTest;

class NonPublicIpv4AddressTest extends BaseTest
{
    public function testValidateMacAddressExample()
    {
        $basicUnfilledRules = [
            'ip_address'  => 'sometimes|non_public_ipv4',
            'mac_address'   => 'sometimes',
        ];

        $v = $this->getValidator()->make([
            'ip_address' => '192.168.1.1',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => 'fe80::/10', // Valid non-public IP but ipv6 not ipv4.
            'mac_address' => 'I"M NOT AN MAC ADDRESS',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '192.169.1.1',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '172.16.12.32',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '172.15.122.32',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '172.30.245.242',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '172.31.245.242',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '172.32.245.242',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '9.10.10.10',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '10.10.10.10',
            'mac_address' => '00:A0:C9:14:C8:29',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '10.240.255.120',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => '11.240.255.120',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());
    }
}
