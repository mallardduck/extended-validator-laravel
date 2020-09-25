<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Validation\Validator;

class PublicIpv6 extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName(__CLASS__);
        parent::__construct(
            $ruleName,
            static function (
                string $attribute,
                $value
            ) {
                return filter_var(
                    $value,
                    FILTER_VALIDATE_IP,
                    FILTER_FLAG_IPV6 | FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE
                ) !== false;
            },
            'The :attribute field must be a valid public IPv6 address.',
            null
        );
    }
}