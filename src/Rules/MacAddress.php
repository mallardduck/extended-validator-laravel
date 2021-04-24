<?php

namespace MallardDuck\ExtendedValidator\Rules;

final class MacAddress extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getImplicitRuleName();
        parent::__construct(
            static function (
                string $attribute,
                $value
            ) {
                return filter_var($value, FILTER_VALIDATE_MAC) !== false;
            },
            'The :attribute field must be a valid MAC address.',
            null
        );
    }
}
