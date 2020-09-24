<?php

namespace MallardDuck\UnfilledValidator\Tests\Rules;

use MallardDuck\UnfilledValidator\Tests\BaseTest;

class PublicIpv6AddressTest extends BaseTest
{
    public function testValidateMacAddressExample()
    {
        $basicUnfilledRules = [
            'ip_address'  => 'sometimes|public_ipv6',
            'mac_address'   => 'sometimes',
        ];

        $v = $this->getValidator()->make([
            'ip_address' => '::1', // Loopback IPv6
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '8.8.8.8', // Valid IP but ipv4 not ipv6.
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '2001:4860:4860::8888',
            'mac_address' => 'I"M NOT AN MAC ADDRESS',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());

        $v = $this->getValidator()->make([
            'ip_address' => 'fe80::/10', // Valid IPv6 but local not public.
            'mac_address' => 'I"M NOT AN MAC ADDRESS',
        ], $basicUnfilledRules);
        $this->assertTrue($v->fails());

        $v = $this->getValidator()->make([
            'ip_address' => '2001:4860:4860::8844',
            'mac_address' => '00:A0:C9:14:C8:29',
        ], $basicUnfilledRules);
        $this->assertTrue($v->passes());
    }
}
