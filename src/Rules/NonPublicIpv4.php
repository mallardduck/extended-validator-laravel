<?php

namespace MallardDuck\ExtendedValidator\Rules;

final class NonPublicIpv4 extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName(__CLASS__);
        parent::__construct(
            $ruleName,
            function (
                string $attribute,
                $value
            ) {
                // Eager return as false for anything that's just flat out not an IP.
                if (false === filter_var($value, FILTER_VALIDATE_IP)) {
                    return false;
                }

                if (false === filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE) ||
                    false === filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)
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
