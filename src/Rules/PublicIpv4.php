<?php

namespace MallardDuck\ExtendedValidator\Rules;

final class PublicIpv4 extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName();
        parent::__construct(
            function (
                string $attribute,
                $value
            ) {
                return filter_var(
                        $value,
                        FILTER_VALIDATE_IP,
                        FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE
                    ) !== false;
            },
            'The :attribute field must be a valid public IPv4 address.',
            null
        );
    }
}
