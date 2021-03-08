<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Validation\Validator;

final class MacAddress extends BaseRule
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
                return filter_var($value, FILTER_VALIDATE_MAC) !== false;
            },
            'The :attribute field must be a valid MAC address.',
            null
        );
    }
}
