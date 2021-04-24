<?php

namespace MallardDuck\ExtendedValidator\Rules;

final class NonPublicIpv4 extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName();
        parent::__construct(
            function (
                string $attribute,
                $value
            ) {
                // Eager return as false for anything that's just flat out not an IP.
                if (false === filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    return false;
                }

                if (
                    filter_var(
                        $value,
                        FILTER_VALIDATE_IP,
                        FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE
                    ) === false
                ) {
                    return true;
                }

                return false;
            },
            'The :attribute field must be a valid non-public IPv4 address.',
            null
        );
    }
}
