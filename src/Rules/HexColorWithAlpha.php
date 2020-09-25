<?php

namespace MallardDuck\ExtendedValidator\Rules;

use Illuminate\Validation\Validator;

class HexColorWithAlpha extends BaseRule
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
                return (bool) preg_match('/^#?(?:[0-9a-fA-F]{2})(?:[0-9a-fA-F]{3}){1,2}$/', $value, $results) !== false;
            },
            'The :attribute field must be a valid 5 or 8 character HEX color code with Alpha channel.',
            null
        );
    }
}
