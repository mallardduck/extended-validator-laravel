<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Validation\Validator;

class MacAddress extends BaseRule
{
    public function __construct()
    {
        $ruleName = $this->getRuleName(__CLASS__);
        parent::__construct(
            $ruleName,
            function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                return filter_var($value, FILTER_VALIDATE_MAC) !== false;
            },
            'The :attribute field must be a valid MAC address.',
            null
        );
    }
}
