<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator\Rules;

final class MacAddress extends BaseRule
{
    public function __construct()
    {
        parent::__construct(
            static function (
                string $attribute,
                $value
            ) {
                return filter_var($value, FILTER_VALIDATE_MAC) !== false;
            },
            'The :attribute field must be a valid MAC address.'
        );
    }
}
